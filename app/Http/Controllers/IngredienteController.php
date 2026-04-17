<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    /**
     * Listar ingredientes
     */
    public function index()
    {
        return response()->json(Ingrediente::all());
    }

    /**
     * Crear ingrediente
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'tipo' => 'nullable|string|max:100',
            'imagen' => 'nullable|string|max:255',
        ]);

        $ingrediente = Ingrediente::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'imagen' => $request->imagen,
        ]);

        return response()->json([
            'message' => 'Ingrediente creado correctamente',
            'data' => $ingrediente
        ]);
    }

    /**
     * Ver ingrediente
     */
    public function show($id)
    {
        return response()->json(
            Ingrediente::findOrFail($id)
        );
    }

    /**
     * Eliminar ingrediente
     */
    public function destroy($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->delete();

        return response()->json([
            'message' => 'Ingrediente eliminado correctamente'
        ]);
    }
}
