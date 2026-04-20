<?php

use App\Http\Controllers\ProfileController;
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
        $traducciones = config('ingredients');

        // Ingredientes que el usuario ya tiene
        $misIngredientes = DB::table('lista_ingredientes')
            ->where('id_usuario', auth()->id())
            ->pluck('id_ingrediente')
            ->toArray();

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
            ->where('ingrediente', request('ingredient'))
            ->delete();

        return back();
    })->name('ingredientes.eliminar');


    // Mis ingredientes
    Route::get('/mis-ingredientes', function () {

        $traducciones = config('ingredients');

        $misIngredientes = DB::table('lista_ingredientes')
            ->where('id_usuario', auth()->id())
            ->pluck('id_ingrediente')
            ->toArray();

        return view('ingredientes.mis_ingredientes', compact('misIngredientes', 'traducciones'));
    })->name('mis.ingredientes');


    /*
    |--------------------------------------------------------------------------
    | Recetas
    |--------------------------------------------------------------------------
    */
    Route::get('/recetas', function () {
        return view('recetas.index');
    })->name('recetas.index');


    /*
    |--------------------------------------------------------------------------
    | Favoritos
    |--------------------------------------------------------------------------
    */
    Route::get('/favoritos', function () {
        return view('favoritos.index');
    })->name('favoritos.index');


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
