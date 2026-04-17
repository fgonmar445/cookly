<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index()
    {
        return Ingrediente::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        $ingrediente = Ingrediente::create($request->all());

        return response()->json($ingrediente);
    }

    public function show($id)
    {
        return Ingrediente::findOrFail($id);
    }

    public function destroy($id)
    {
        Ingrediente::destroy($id);

        return response()->json(['message' => 'Eliminado']);
    }
}
