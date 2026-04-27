<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ListaIngredienteController;

/*
|-------------------------
| INGREDIENTES
|-------------------------
*/

Route::get('/ingredientes', [IngredienteController::class, 'index']);
Route::post('/ingredientes', [IngredienteController::class, 'store']);
Route::get('/ingredientes/{id}', [IngredienteController::class, 'show']);
Route::delete('/ingredientes/{id}', [IngredienteController::class, 'destroy']);

/*
|-------------------------
| RECETAS
|-------------------------
*/
Route::get('/recetas', [RecetaController::class, 'index']);
Route::post('/recetas', [RecetaController::class, 'store']);
Route::get('/recetas/{id}', [RecetaController::class, 'show']);

// API externa
Route::get('/recetas-api/{nombre}', [RecetaController::class, 'fromApi']);

/*
|-------------------------
| FAVORITOS
|-------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos', [FavoritoController::class, 'store']);
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'destroy']);
});


/*
|-------------------------
| LISTA INGREDIENTES
|-------------------------
*/
Route::get('/lista-ingredientes', [ListaIngredienteController::class, 'index']);
Route::post('/lista-ingredientes', [ListaIngredienteController::class, 'store']);
Route::delete('/lista-ingredientes/{id}', [ListaIngredienteController::class, 'destroy']);

/*
|-------------------------
| CATEGORÍAS
|-------------------------
*/
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::post('/categorias', [CategoriaController::class, 'store']);
Route::get('/categorias/{id}', [CategoriaController::class, 'show']);
