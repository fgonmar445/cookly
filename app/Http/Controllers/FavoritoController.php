<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Listar favoritos del usuario logueado
     */
    public function index(Request $request)
    {
        return response()->json(Favorito::where('id_usuario', $request->user()->id)->get());
    }

    /**
     * Añadir favorito
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_receta' => 'required|exists:recetas,id_receta',
        ]);

        $favorito = Favorito::create([
            'id_usuario' => $request->user()->id,
            'id_receta' => $request->id_receta,
            'fecha_guardado' => now(),
        ]);

        return response()->json([
            'message' => 'Favorito añadido correctamente',
            'data' => $favorito
        ]);
    }

    /**
     * Eliminar favorito
     */
    public function destroy(Request $request, $id)
    {
        $favorito = Favorito::where('id_favorito', $id)
            ->where('id_usuario', $request->user()->id)
            ->firstOrFail();

        $favorito->delete();

        return response()->json([
            'message' => 'Favorito eliminado correctamente'
        ]);
    }
}
