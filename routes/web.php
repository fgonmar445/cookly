<?php

use App\Http\Controllers\ListaIngredienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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

    // Crear receta
    Route::get('/recetas/crear', [RecetaController::class, 'create'])->name('recetas.create');
    Route::post('/recetas', [RecetaController::class, 'store'])->name('recetas.store');

    // Mis recetas
    Route::get('/mis-recetas', [RecetaController::class, 'misRecetas'])->name('recetas.mias');

    // Editar receta
    Route::get('/recetas/{id}/editar', [RecetaController::class, 'edit'])->name('recetas.edit');

    // Actualizar receta
    Route::put('/recetas/{id}', [RecetaController::class, 'update'])->name('recetas.update');

    // Borrar receta
    Route::delete('/recetas/{id}', [RecetaController::class, 'destroy'])->name('recetas.destroy');

    Route::get('/recetas/usuarios', [RecetaController::class, 'recetasUsuarios'])
        ->name('recetas.usuarios');
});


/*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
Route::get('/dashboard', function () {

    // FAVORITOS DEL USUARIO (solo IDs)
    $favoritosUsuario = DB::table('favoritos')
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->where('favoritos.id_usuario', auth()->id())
        ->pluck('recetas.id_receta_api')
        ->toArray();


    // -------------------------
    // 1. RECETAS ALEATORIAS (3 con caché 1 hora)
    // -------------------------
    $random = Cache::remember('random_recipes_' . auth()->id(), 3600, function () use ($favoritosUsuario) {

        $arr = [];

        for ($i = 0; $i < 3; $i++) {
            $data = json_decode(file_get_contents("https://www.themealdb.com/api/json/v2/1/random.php"), true);

            if (!empty($data['meals'][0])) {
                $meal = $data['meals'][0];

                $arr[] = [
                    'idMeal' => $meal['idMeal'],
                    'strMeal' => $meal['strMeal'],
                    'strMealThumb' => $meal['strMealThumb'],
                    'esFavorita' => in_array($meal['idMeal'], $favoritosUsuario)
                ];
            }
        }

        return $arr;
    });

    // -------------------------
    // 2. POPULARES (3 con caché 1 hora)
    // -------------------------
    $populares = DB::table('favoritos')
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->select(
            'recetas.id_receta',
            'recetas.id_receta_api as idMeal',
            'recetas.nombre as strMeal',
            'recetas.imagen as strMealThumb',
            'recetas.id_usuario',
            DB::raw('COUNT(favoritos.id_favorito) as total_favs')
        )
        ->groupBy('recetas.id_receta', 'recetas.id_receta_api', 'recetas.nombre', 'recetas.imagen', 'recetas.id_usuario')
        ->orderByDesc('total_favs')
        ->limit(3)
        ->get()
        ->map(function ($r) use ($favoritosUsuario) {
            return [
                'idMeal' => $r->idMeal,
                'strMeal' => $r->strMeal,
                'strMealThumb' => $r->strMealThumb,
                'esFavorita' => in_array($r->idMeal, $favoritosUsuario),
                'id_usuario' => $r->id_usuario,
                'id_receta' => $r->id_receta
            ];
        });



    // -------------------------
    // 3. RECOMENDACIONES (caché 10 minutos)
    // -------------------------
    $cacheKey = 'recomendaciones_' . auth()->id();

    $recomendaciones = Cache::remember($cacheKey, 600, function () use ($favoritosUsuario) {

        // INGREDIENTES DEL USUARIO
        $misIngredientes = DB::table('lista_ingredientes')
            ->join('ingredientes', 'lista_ingredientes.id_ingrediente', '=', 'ingredientes.id_ingrediente')
            ->where('lista_ingredientes.id_usuario', auth()->id())
            ->pluck('ingredientes.nombre')
            ->map(fn($n) => strtolower($n))
            ->toArray();

        // INGREDIENTES VÁLIDOS PARA THEMEALDB
        $validos = [
            'chicken',
            'beef',
            'lamb',
            'pork',
            'salmon',
            'shrimp',
            'rice',
            'pasta',
            'tomato',
            'onions',
            'garlic',
            'egg',
            'milk',
            'cheese',
            'bread'
        ];

        // FILTRAR SOLO LOS VÁLIDOS
        $ingredientesFiltrados = array_values(array_intersect($misIngredientes, $validos));

        // LIMITAR A 3 PARA QUE SEA RÁPIDO
        $ingredientesFiltrados = array_slice($ingredientesFiltrados, 0, 3);

        $recetas = [];

        foreach ($ingredientesFiltrados as $ing) {

            $data = json_decode(file_get_contents("https://www.themealdb.com/api/json/v1/1/filter.php?i=" . urlencode($ing)), true);

            if (empty($data['meals'])) continue;

            foreach ($data['meals'] as $meal) {

                $id = $meal['idMeal'];

                if (!isset($recetas[$id])) {
                    $recetas[$id] = [
                        'idMeal' => $meal['idMeal'],
                        'strMeal' => $meal['strMeal'],
                        'strMealThumb' => $meal['strMealThumb'],
                        'match_count' => 0,
                        'esFavorita' => in_array($meal['idMeal'], $favoritosUsuario)
                    ];
                }

                $recetas[$id]['match_count']++;
            }
        }

        // ORDENAR POR COINCIDENCIAS
        usort($recetas, fn($a, $b) => $b['match_count'] <=> $a['match_count']);

        // TOMAR 3
        return array_slice($recetas, 0, 3);
    });

    // -------------------------
    // 4. FAVORITOS RECIENTES
    // -------------------------
    $favoritos = DB::table('favoritos')
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->select('recetas.*')
        ->where('favoritos.id_usuario', auth()->id())
        ->orderBy('favoritos.id_favorito', 'desc')
        ->limit(3)
        ->get()
        ->map(function ($f) {
            return [
                'idMeal' => $f->id_receta_api,
                'id_receta' => $f->id_receta,
                'strMeal' => $f->nombre,
                'strMealThumb' => $f->imagen,
                'id_usuario' => $f->id_usuario,
                'esFavorita' => true
            ];
        });

    return view('dashboard', compact('random', 'populares', 'recomendaciones', 'favoritos'));
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

    $traducciones = config('ingredients');
    $reverse = $traducciones['es_to_en'];   // español → inglés


    $search = strtolower(trim(request('search')));
    $resultados = [];

    // Ingredientes que el usuario ya tiene (solo nombres para el in_array)
    $misIngredientes = DB::table('lista_ingredientes')
        ->join('ingredientes', 'lista_ingredientes.id_ingrediente', '=', 'ingredientes.id_ingrediente')
        ->where('lista_ingredientes.id_usuario', auth()->id())
        ->pluck('ingredientes.nombre')
        ->map(function ($n) {
            $n = strtolower(trim($n));
            $n = str_replace(
                ['á', 'é', 'í', 'ó', 'ú', 'ñ'],
                ['a', 'e', 'i', 'o', 'u', 'n'],
                $n
            );
            return $n;
        })

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
        ->pluck('recetas.id_receta_api')
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
        ->pluck('recetas.id_receta_api')
        ->filter()
        ->toArray();

    return view('recetas.buscar_nombre', compact('favoritos'));
})->name('buscar.nombre');

// Buscar por ingredientes
Route::get('/buscar/ingredientes', function () {
    $favoritos = auth()->user()
        ->favoritos()
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->pluck('recetas.id_receta_api')
        ->filter()
        ->toArray();

    return view('recetas.buscar_ingredientes', compact('favoritos'));
})->name('buscar.ingredientes');

// Buscar por categoría
Route::get('/buscar/categorias', function () {
    $favoritos = auth()->user()
        ->favoritos()
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->pluck('recetas.id_receta_api')
        ->filter()
        ->toArray();

    return view('recetas.buscar_categorias', compact('favoritos'));
})->name('buscar.categorias');

// Buscar por cocina (área)
Route::get('/buscar/areas', function () {
    $favoritos = auth()->user()
        ->favoritos()
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->pluck('recetas.id_receta_api')
        ->filter()
        ->toArray();

    return view('recetas.buscar_areas', compact('favoritos'));
})->name('buscar.areas');

// Receta aleatoria
Route::get('/buscar/aleatoria', function () {
    $favoritos = auth()->user()
        ->favoritos()
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->pluck('recetas.id_receta_api')
        ->filter()
        ->toArray();

    return view('recetas.aleatoria', compact('favoritos'));
})->name('buscar.aleatoria');

// Recomendador
Route::get('/buscar/recomendador', function () {
    $favoritos = auth()->user()
        ->favoritos()
        ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
        ->pluck('recetas.id_receta_api')
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


/*
|--------------------------------------------------------------------------
| Rutas de autenticación
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Rutas de Administración
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarios', [AdminController::class, 'users'])->name('users');
    Route::post('/usuarios/{user}/rol', [AdminController::class, 'changeRole'])->name('users.role');
    Route::delete('/usuarios/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    Route::get('/recetas', [AdminController::class, 'recipes'])->name('recipes');
    Route::delete('/recetas/{recipe}', [AdminController::class, 'deleteRecipe'])->name('recipes.delete');

    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});

require __DIR__ . '/auth.php';
