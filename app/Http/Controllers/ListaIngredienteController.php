<?php

namespace App\Http\Controllers;

use App\Models\ListaIngrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListaIngredienteController extends Controller
{
    /**
     * Listar ingredientes del usuario logueado
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $misIngredientes = DB::table('ingredientes')
            ->join('lista_ingredientes', 'ingredientes.id_ingrediente', '=', 'lista_ingredientes.id_ingrediente')
            ->where('lista_ingredientes.id_usuario', $userId)
            ->select('ingredientes.*', 'lista_ingredientes.id_lista')
            ->get();

        return view('ingredientes.mis_ingredientes', [
            'misIngredientes' => $misIngredientes,
            'traducciones' => config('ingredients') ?? []
        ]);
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
