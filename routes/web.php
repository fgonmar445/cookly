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
        return view('dashboard');
    })->name('dashboard');


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

            $url = "https://www.themealdb.com/api/json/v1/1/search.php?i=" . urlencode($nombre);
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

        // Ingredientes que el usuario ya tiene
        $misIngredientes = DB::table('lista_ingredientes')
            ->where('id_usuario', auth()->id())
            ->get();



        // 1. Descargar lista completa de ingredientes
        $url = "https://www.themealdb.com/api/json/v1/1/list.php?i=list";
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
        }

        return view('ingredientes.todos', compact('resultados', 'traducciones', 'search', 'misIngredientes'));
    })->name('ingredientes.todos');




    /*
    |--------------------------------------------------------------------------
    | Recetas
    |--------------------------------------------------------------------------
    */
    Route::get('/recetas', function () {
        return view('recetas.index');
    })->name('recetas');

    // Página principal de búsqueda
    Route::get('/buscar', function () {
        return view('recetas.index');
    })->name('buscar');

    // Buscar por nombre
    Route::get('/buscar/nombre', function () {
        return view('recetas.buscar_nombre');
    })->name('buscar.nombre');

    // Buscar por ingredientes
    Route::get('/buscar/ingredientes', function () {
        return view('recetas.buscar_ingredientes');
    })->name('buscar.ingredientes');

    // Buscar por categoría
    Route::get('/buscar/categorias', function () {
        return view('recetas.buscar_categorias');
    })->name('buscar.categorias');

    // Buscar por área
    Route::get('/buscar/areas', function () {
        return view('recetas.buscar_areas');
    })->name('buscar.areas');

    // Receta aleatoria
    Route::get('/buscar/aleatoria', function () {
        return view('recetas.aleatoria');
    })->name('buscar.aleatoria');

    // Recomendador
    Route::get('/buscar/recomendador', function () {
        return view('recetas.recomendador');
    })->name('buscar.recomendador');

    Route::get('/receta/{id}', [RecetaController::class, 'show'])->name('receta.show');





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
                'id_receta_api' => $receta->id_receta_api,
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
