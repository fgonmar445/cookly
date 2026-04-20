<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    // SOLO LECTURA

    public function index()
    {
        return response()->json(Ingrediente::all());
    }

    public function show($id)
    {
        return response()->json(
            Ingrediente::findOrFail($id)
        );
    }
}
