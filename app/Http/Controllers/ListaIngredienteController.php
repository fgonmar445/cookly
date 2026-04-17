<?php

namespace App\Http\Controllers;

use App\Models\ListaIngrediente;
use Illuminate\Http\Request;

class ListaIngredienteController extends Controller
{
    public function index()
    {
        return ListaIngrediente::all();
    }

    public function store(Request $request)
    {
        $lista = ListaIngrediente::create([
            'id_usuario' => $request->id_usuario,
            'id_ingrediente' => $request->id_ingrediente,
            'fecha_guardado' => now()
        ]);

        return response()->json($lista);
    }

    public function destroy($id)
    {
        ListaIngrediente::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}
