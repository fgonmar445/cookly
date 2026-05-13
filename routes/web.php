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

    // --- Dashboard ---
    Route::get('/dashboard', function () {
        if (auth()->user()->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // FAVORITOS DEL USUARIO
        $favoritosApi = DB::table('favoritos')
            ->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')
            ->where('favoritos.id_usuario', auth()->id())
            ->whereNotNull('recetas.id_receta_api')
            ->pluck('recetas.id_receta_api')
            ->toArray();

        $favoritosLocales = DB::table('favoritos')
            ->where('id_usuario', auth()->id())
            ->pluck('id_receta')
            ->toArray();

        // 1. RECETAS ALEATORIAS
        $random = Cache::remember('random_recipes_' . auth()->id(), 3600, function () {
            $arr = [];
            for ($i = 0; $i < 3; $i++) {
                $data = json_decode(@file_get_contents("https://www.themealdb.com/api/json/v2/1/random.php"), true);
                if (!empty($data['meals'][0])) {
                    $meal = $data['meals'][0];
                    $arr[] = [
                        'idMeal' => $meal['idMeal'],
                        'strMeal' => $meal['strMeal'],
                        'strMealThumb' => $meal['strMealThumb']
                    ];
                }
            }
            return $arr;
        });

        foreach ($random as &$r) {
            $r['esFavorita'] = in_array($r['idMeal'], $favoritosApi);
        }
        unset($r);

        // 2. POPULARES
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
            ->map(function ($r) use ($favoritosApi, $favoritosLocales) {
                return [
                    'idMeal' => $r->idMeal,
                    'strMeal' => $r->strMeal,
                    'strMealThumb' => $r->strMealThumb,
                    'esFavorita' => $r->idMeal ? in_array($r->idMeal, $favoritosApi) : in_array($r->id_receta, $favoritosLocales),
                    'id_usuario' => $r->id_usuario,
                    'id_receta' => $r->id_receta
                ];
            });

        // 3. RECOMENDACIONES
        $cacheKey = 'recomendaciones_' . auth()->id();
        $recomendaciones = Cache::remember($cacheKey, 600, function () use ($favoritosApi) {
            $misIngredientes = DB::table('lista_ingredientes')
                ->join('ingredientes', 'lista_ingredientes.id_ingrediente', '=', 'ingredientes.id_ingrediente')
                ->where('lista_ingredientes.id_usuario', auth()->id())
                ->pluck('ingredientes.nombre')
                ->map(fn($n) => strtolower($n))
                ->toArray();

            $validos = ['chicken', 'beef', 'lamb', 'pork', 'salmon', 'shrimp', 'rice', 'pasta', 'tomato', 'onions', 'garlic', 'egg', 'milk', 'cheese', 'bread'];
            $ingredientesFiltrados = array_values(array_intersect($misIngredientes, $validos));
            $ingredientesFiltrados = array_slice($ingredientesFiltrados, 0, 3);

            $recetas = [];
            foreach ($ingredientesFiltrados as $ing) {
                $data = json_decode(@file_get_contents("https://www.themealdb.com/api/json/v1/1/filter.php?i=" . urlencode($ing)), true);
                if (empty($data['meals'])) continue;
                foreach ($data['meals'] as $meal) {
                    $id = $meal['idMeal'];
                    if (!isset($recetas[$id])) {
                        $recetas[$id] = [
                            'idMeal' => $meal['idMeal'],
                            'strMeal' => $meal['strMeal'],
                            'strMealThumb' => $meal['strMealThumb'],
                            'match_count' => 0
                        ];
                    }
                    $recetas[$id]['match_count']++;
                }
            }
            usort($recetas, fn($a, $b) => $b['match_count'] <=> $a['match_count']);
            return array_slice($recetas, 0, 3);
        });

        foreach ($recomendaciones as &$r) {
            $r['esFavorita'] = in_array($r['idMeal'], $favoritosApi);
        }
        unset($r);

        // 4. FAVORITOS RECIENTES
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

    // --- Recetas (CRUD) ---
    Route::get('/recetas/crear', [RecetaController::class, 'create'])->name('recetas.create');
    Route::post('/recetas', [RecetaController::class, 'store'])->name('recetas.store');
    Route::get('/mis-recetas', [RecetaController::class, 'misRecetas'])->name('recetas.mias');
    Route::get('/recetas/{id}/editar', [RecetaController::class, 'edit'])->name('recetas.edit');
    Route::put('/recetas/{id}', [RecetaController::class, 'update'])->name('recetas.update');
    Route::delete('/recetas/{id}', [RecetaController::class, 'destroy'])->name('recetas.destroy');
    Route::get('/recetas/usuarios', [RecetaController::class, 'recetasUsuarios'])->name('recetas.usuarios');
    Route::get('/receta/{id}', [RecetaController::class, 'show'])->name('recetas.show');

    // --- Ingredientes ---
    Route::get('/ingredientes', function () {
        $categorias = config('categories');
        $traducciones = config('ingredients.en_to_es');
        $misIngredientes = DB::table('lista_ingredientes')->where('id_usuario', auth()->id())->get();
        return view('ingredientes.index', compact('categorias', 'traducciones', 'misIngredientes'));
    })->name('ingredientes.index');

    Route::post('/ingredientes/add', function () {
        $nombre = request('ingredient');
        $ingrediente = DB::table('ingredientes')->where('nombre', $nombre)->first();
        if (!$ingrediente) {
            $url = "https://www.themealdb.com/api/json/v2/1/search.php?i=" . urlencode($nombre);
            $data = json_decode(@file_get_contents($url), true);
            $info = $data['ingredients'][0] ?? null;
            
            if ($info) {
                // Es un ingrediente de la API
                $ingrediente = \App\Models\Ingrediente::create([
                    'nombre' => $nombre,
                    'categoria' => null,
                    'es_base' => false,
                ]);
            } else {
                // Es un ingrediente personalizado por el usuario
                $ingrediente = \App\Models\Ingrediente::create([
                    'nombre' => $nombre,
                    'categoria' => 'Otros',
                    'es_base' => false,
                ]);
            }
        }
        DB::table('lista_ingredientes')->insert([
            'id_usuario' => auth()->id(),
            'id_ingrediente' => $ingrediente->id_ingrediente,
            'fecha_guardado' => now(),
        ]);
        return back();
    })->name('ingredientes.add');

    Route::post('/ingredientes/eliminar', function () {
        DB::table('lista_ingredientes')
            ->where('id_usuario', auth()->id())
            ->where('id_lista', request('id_lista'))
            ->delete();
        return back();
    })->name('ingredientes.eliminar');

    Route::get('/mis-ingredientes', [ListaIngredienteController::class, 'index'])->name('mis.ingredientes');

    Route::get('/ingredientes/todos', function () {
        $traducciones = config('ingredients');
        $reverse = $traducciones['es_to_en'];
        $search = strtolower(trim(request('search')));
        $resultados = [];
        $misIngredientes = DB::table('lista_ingredientes')
            ->join('ingredientes', 'lista_ingredientes.id_ingrediente', '=', 'ingredientes.id_ingrediente')
            ->where('lista_ingredientes.id_usuario', auth()->id())
            ->pluck('ingredientes.nombre')
            ->map(fn($n) => str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], strtolower(trim($n))))
            ->toArray();

        $url = "https://www.themealdb.com/api/json/v2/1/list.php?i=list";
        $data = json_decode(@file_get_contents($url), true);
        $lista = $data['meals'] ?? [];

        if ($search) {
            if (array_key_exists($search, $reverse)) $search = $reverse[$search];
            $resultados = array_values(array_filter($lista, fn($item) => str_contains(strtolower($item['strIngredient']), $search)));
        }
        return view('ingredientes.todos', compact('resultados', 'traducciones', 'search', 'misIngredientes'));
    })->name('ingredientes.todos');

    // --- Búsqueda de Recetas ---
    Route::get('/buscar', function () {
        $favoritos = auth()->user()->favoritos()->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')->pluck('recetas.id_receta_api')->filter()->toArray();
        return view('recetas.index', compact('favoritos'));
    })->name('buscar');

    Route::get('/buscar/nombre', function () {
        $favoritos = auth()->user()->favoritos()->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')->pluck('recetas.id_receta_api')->filter()->toArray();
        return view('recetas.buscar_nombre', compact('favoritos'));
    })->name('buscar.nombre');

    Route::get('/buscar/ingredientes', function () {
        $favoritos = auth()->user()->favoritos()->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')->pluck('recetas.id_receta_api')->filter()->toArray();
        return view('recetas.buscar_ingredientes', compact('favoritos'));
    })->name('buscar.ingredientes');

    Route::get('/buscar/categorias', function () {
        $favoritos = auth()->user()->favoritos()->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')->pluck('recetas.id_receta_api')->filter()->toArray();
        return view('recetas.buscar_categorias', compact('favoritos'));
    })->name('buscar.categorias');

    Route::get('/buscar/cocinas', function () {
        $favoritos = auth()->user()->favoritos()->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')->pluck('recetas.id_receta_api')->filter()->toArray();
        return view('recetas.buscar_cocina', compact('favoritos'));
    })->name('buscar.cocinas');

    Route::get('/buscar/aleatoria', function () {
        $favoritos = auth()->user()->favoritos()->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')->pluck('recetas.id_receta_api')->filter()->toArray();
        return view('recetas.aleatoria', compact('favoritos'));
    })->name('buscar.aleatoria');

    Route::get('/buscar/recomendador', function () {
        $favoritos = auth()->user()->favoritos()->join('recetas', 'favoritos.id_receta', '=', 'recetas.id_receta')->pluck('recetas.id_receta_api')->filter()->toArray();
        return view('recetas.recomendador', compact('favoritos'));
    })->name('buscar.recomendador');

    // --- Favoritos ---
    Route::get('/favoritos', function () {
        return view('favoritos.index');
    })->name('favoritos.index');

    Route::post('/favoritos/toggle/{id}', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');

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
                'cocina' => $receta->cocina,
            ];
        }
        return response()->json($resultado);
    })->name('favoritos.json');

    // --- Perfil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- API Interna ---
    Route::get('/api/receta-interna/{idMeal}', function ($idMeal) {
        $receta = \App\Models\Receta::where('id_receta', $idMeal)->first();
        return [
            'id' => $receta ? $receta->id_receta : $idMeal
        ];
    });

});


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

    Route::resource('ingredientes', \App\Http\Controllers\AdminIngredienteController::class);

    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});

require __DIR__ . '/auth.php';
