<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Listar todas las categorías
     */
    public function index()
    {
        return response()->json(Categoria::all());
    }

    /**
     * Crear categoría
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data' => $categoria
        ]);
    }

    /**
     * Ver una categoría
     */
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);

        return response()->json($categoria);
    }
}
