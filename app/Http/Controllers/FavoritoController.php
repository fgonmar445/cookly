<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function index()
    {
        return Favorito::all();
    }

    public function store(Request $request)
    {
        $favorito = Favorito::create([
            'id_usuario' => $request->id_usuario,
            'id_receta_api' => $request->id_receta_api,
            'fecha_guardado' => now()
        ]);

        return response()->json($favorito);
    }

    public function destroy($id)
    {
        Favorito::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}
