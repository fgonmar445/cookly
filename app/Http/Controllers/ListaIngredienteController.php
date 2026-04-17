<?php

namespace App\Http\Controllers;

use App\Models\ListaIngrediente;
use Illuminate\Http\Request;

class ListaIngredienteController extends Controller
{
    /**
     * Listar ingredientes del usuario logueado
     */
    public function index(Request $request)
    {
        return ListaIngrediente::where('id_usuario', $request->user()->id)->get();
    }

    /**
     * Añadir ingrediente a la lista del usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ingrediente' => 'required|integer'
        ]);

        $lista = ListaIngrediente::create([
            'id_usuario' => $request->user()->id,
            'id_ingrediente' => $request->id_ingrediente,
            'fecha_guardado' => now()
        ]);

        return response()->json([
            'message' => 'Ingrediente añadido correctamente',
            'data' => $lista
        ]);
    }

    /**
     * Eliminar ingrediente de la lista del usuario
     */
    public function destroy(Request $request, $id)
    {
        $registro = ListaIngrediente::where('id_lista', $id)
            ->where('id_usuario', $request->user()->id)
            ->firstOrFail();

        $registro->delete();

        return response()->json([
            'message' => 'Eliminado correctamente'
        ]);
    }
}
