<?php

use App\Http\Controllers\ListaIngredienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\FavoritoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {

        dd($misIngredientesES, $misIngredientesEN);


        // 1. Receta aleatoria
        $randomUrl = "https://www.themealdb.com/api/json/v2/1/random.php";
        $randomData = json_decode(file_get_contents($randomUrl), true);
        $random = $randomData['meals'][0] ?? null;

        // 2. Recetas populares
        $popularUrl = "https://www.themealdb.com/api/json/v2/1/filter.php?c=Beef";
        $popularData = json_decode(file_get_contents($popularUrl), true);
        $populares = array_slice($popularData['meals'] ?? [], 0, 3);

        // 3. Favoritos del usuario
        $favoritos = DB::table('favoritos')
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->where('favoritos.id_usuario', auth()->id())
            ->orderBy('favoritos.id_favorito', 'desc')
            ->limit(3)
            ->get();

        // 4. Recomendaciones basadas en ingredientes del usuario
        $dict = config('ingredients'); // tu archivo
        $esToEn = $dict['es_to_en'];   // ← ESTE es el diccionario correcto

        // Ingredientes del usuario en español
        $misIngredientesES = DB::table('lista_ingredientes')
            ->join('ingredientes', 'lista_ingredientes.id_ingrediente', '=', 'ingredientes.id_ingrediente')
            ->where('lista_ingredientes.id_usuario', auth()->id())
            ->pluck('ingredientes.nombre')
            ->map(fn($n) => strtolower($n))
            ->toArray();

        // Traducir al inglés usando es_to_en
        $misIngredientesEN = array_map(function ($ing) use ($esToEn) {
            return $esToEn[$ing] ?? null;
        }, $misIngredientesES);

        // Limpiar nulls
        $misIngredientesEN = array_filter($misIngredientesEN);

        $recomendaciones = [];

        if (!empty($misIngredientesEN)) {

            // Usamos el primer ingrediente traducido
            $primero = urlencode($misIngredientesEN[array_key_first($misIngredientesEN)]);

            $recUrl = "https://www.themealdb.com/api/json/v2/1/filter.php?i={$primero}";
            $recData = json_decode(file_get_contents($recUrl), true);

            $recomendaciones = array_slice($recData['meals'] ?? [], 0, 3);
        }

        return view('dashboard', compact('random', 'populares', 'favoritos', 'recomendaciones'));
    })->middleware(['auth'])->name('dashboard');



    /*
    |--------------------------------------------------------------------------
    | INGREDIENTES (CORREGIDO)
    |--------------------------------------------------------------------------
    |
    | Aquí ya NO usamos las categorías de TheMealDB.
    | Aquí ya NO usamos /ingredientes/{categoria}.
    | Aquí solo usamos tus 30 ingredientes definidos en config/categories.php
    |
    */

    // Página principal de ingredientes (muestra 30 ingredientes)
    Route::get('/ingredientes', function () {

        $categorias = config('categories');
        $traducciones = config('ingredients.en_to_es');

        // Ingredientes que el usuario ya tiene
        $misIngredientes = DB::table('lista_ingredientes')
            ->where('id_usuario', auth()->id())
            ->get();


        return view('ingredientes.index', compact('categorias', 'traducciones', 'misIngredientes'));
    })->name('ingredientes.index');


    // Añadir ingrediente
    Route::post('/ingredientes/add', function () {

        $nombre = request('ingredient'); // ej: "chicken"

        // 1) Buscar si existe en la tabla global
        $ingrediente = DB::table('ingredientes')
            ->where('nombre', $nombre)
            ->first();

        // 2) Si no existe, lo creamos usando la API
        if (!$ingrediente) {

            $url = "https://www.themealdb.com/api/json/v2/1/search.php?i=" . urlencode($nombre);
            $data = json_decode(file_get_contents($url), true);
            $info = $data['ingredients'][0] ?? null;

            DB::table('ingredientes')->insert([
                'nombre' => $nombre,
                'descripcion' => $info['strDescription'] ?? null,
                'imagen' => $info['strIngredientThumb'] ?? null,
                'tipo' => $info['strType'] ?? null,
            ]);

            // Recuperar el ingrediente recién insertado
            $ingrediente = DB::table('ingredientes')
                ->where('nombre', $nombre)
                ->first();
        }

        // 3) Insertar en lista_ingredientes
        DB::table('lista_ingredientes')->insert([
            'id_usuario' => auth()->id(),
            'id_ingrediente' => $ingrediente->id_ingrediente,
            'fecha_guardado' => now(),
        ]);

        return back();
    })->name('ingredientes.add');



    // Eliminar ingrediente
    Route::post('/ingredientes/eliminar', function () {

        DB::table('lista_ingredientes')
            ->where('id_usuario', auth()->id())
            ->where('id_lista', request('id_lista'))
            ->delete();

        return back();
    })->name('ingredientes.eliminar');


    /*
    |--------------------------------------------------------------------------
    | Mis ingredientes
    |--------------------------------------------------------------------------
    */

    Route::get('/mis-ingredientes', [ListaIngredienteController::class, 'index'])
        ->name('mis.ingredientes');

    /*
    |--------------------------------------------------------------------------
    | Todos los ingredientes
    |--------------------------------------------------------------------------
    */
    Route::get('/ingredientes/todos', function () {

        $traducciones = config('ingredients.en_to_es');
        $reverse = config('ingredients_reverse');

        $search = strtolower(trim(request('search')));
        $resultados = [];

        // Ingredientes que el usuario ya tiene (solo nombres para el in_array)
        $misIngredientes = DB::table('lista_ingredientes')
            ->join('ingredientes', 'lista_ingredientes.id_ingrediente', '=', 'ingredientes.id_ingrediente')
            ->where('lista_ingredientes.id_usuario', auth()->id())
            ->pluck('ingredientes.nombre')
            ->map(fn($n) => strtolower($n))
            ->toArray();



        // 1. Descargar lista completa de ingredientes
        $url = "https://www.themealdb.com/api/json/v2/1/list.php?i=list";
        $data = json_decode(file_get_contents($url), true);
        $lista = $data['meals'] ?? [];

        if ($search) {

            // 2. Traducir si el usuario escribe en español
            if (array_key_exists($search, $reverse)) {
                $search = $reverse[$search];
            }

            // 3. Filtrar ingredientes localmente
            $resultados = array_filter($lista, function ($item) use ($search) {
                return str_contains(strtolower($item['strIngredient']), $search);
            });

            // Resetear llaves para que Blade no tenga problemas
            $resultados = array_values($resultados);
        }

        return view('ingredientes.todos', compact('resultados', 'traducciones', 'search', 'misIngredientes'));
    })->name('ingredientes.todos');




    /*
    |--------------------------------------------------------------------------
    | Recetas
    |--------------------------------------------------------------------------
    */
    // Página principal de búsqueda
    Route::get('/buscar', function () {
        $favoritos = auth()->user()
            ->favoritos()
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->pluck('recetas.id_receta')
            ->filter()
            ->toArray();

        return view('recetas.index', compact('favoritos'));
    })->name('buscar');

    Route::get('/receta/{id}', [RecetaController::class, 'show'])->name('recetas.show');

    Route::get('/api/receta-interna/{idMeal}', function ($idMeal) {
        $receta = \App\Models\Receta::where('id_receta', $idMeal)->first();

        return [
            'id' => $receta ? $receta->id_receta : $idMeal
        ];
    });


    // Buscar por nombre
    Route::get('/buscar/nombre', function () {
        $favoritos = auth()->user()
            ->favoritos()
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->pluck('recetas.id_receta')
            ->filter()
            ->toArray();

        return view('recetas.buscar_nombre', compact('favoritos'));
    })->name('buscar.nombre');

    // Buscar por ingredientes
    Route::get('/buscar/ingredientes', function () {
        $favoritos = auth()->user()
            ->favoritos()
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->pluck('recetas.id_receta')
            ->filter()
            ->toArray();

        return view('recetas.buscar_ingredientes', compact('favoritos'));
    })->name('buscar.ingredientes');

    // Buscar por categoría
    Route::get('/buscar/categorias', function () {
        $favoritos = auth()->user()
            ->favoritos()
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->pluck('recetas.id_receta')
            ->filter()
            ->toArray();

        return view('recetas.buscar_categorias', compact('favoritos'));
    })->name('buscar.categorias');

    // Buscar por cocina (área)
    Route::get('/buscar/areas', function () {
        $favoritos = auth()->user()
            ->favoritos()
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->pluck('recetas.id_receta')
            ->filter()
            ->toArray();

        return view('recetas.buscar_areas', compact('favoritos'));
    })->name('buscar.areas');

    // Receta aleatoria
    Route::get('/buscar/aleatoria', function () {
        $favoritos = auth()->user()
            ->favoritos()
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->pluck('recetas.id_receta')
            ->filter()
            ->toArray();

        return view('recetas.aleatoria', compact('favoritos'));
    })->name('buscar.aleatoria');

    // Recomendador
    Route::get('/buscar/recomendador', function () {
        $favoritos = auth()->user()
            ->favoritos()
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->pluck('recetas.id_receta')
            ->filter()
            ->toArray();

        return view('recetas.recomendador', compact('favoritos'));
    })->name('buscar.recomendador');






    /*
    |--------------------------------------------------------------------------
    | Favoritos
    |--------------------------------------------------------------------------
    */
    Route::get('/favoritos', function () {
        return view('favoritos.index');
    })->name('favoritos.index');

    Route::post('/favoritos/toggle/{id}', [FavoritoController::class, 'toggle'])
        ->name('favoritos.toggle')
        ->middleware('auth');

    Route::get('/favoritos-json', function () {
        $user = auth()->user();

        $favoritos = $user->favoritos()->get();

        $resultado = [];

        foreach ($favoritos as $fav) {
            $receta = \App\Models\Receta::find($fav->id_receta);
            if (!$receta) continue;

            $resultado[] = [
                'id_favorito' => $fav->id_favorito,
                'id_receta' => $receta->id_receta,
                'nombre' => $receta->nombre,
                'imagen' => $receta->imagen,
                'categoria' => $receta->categoria,
                'area' => $receta->area,
            ];
        }

        return response()->json($resultado);
    })->name('favoritos.json');


    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
