<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingrediente;
use App\Models\Actividad;

class AdminIngredienteController extends Controller
{
    public function index()
    {
        $ingredientes = Ingrediente::where('es_base', true)->orderBy('categoria')->orderBy('nombre')->paginate(20);
        return view('admin.ingredientes.index', compact('ingredientes'));
    }

    public function create()
    {
        $categorias = [
            'Verduras y hortalizas', 'Carnes', 'Pescados y mariscos', 
            'Lácteos y huevos', 'Cereales y pasta', 'Aceites y condimentos', 'Otros'
        ];
        return view('admin.ingredientes.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150|unique:ingredientes,nombre',
            'categoria' => 'required|string|max:150',
        ]);

        $ingrediente = Ingrediente::create([
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'es_base' => $request->has('es_base'),
        ]);

        Actividad::create([
            'accion' => 'create_ingrediente',
            'descripcion' => "Añadido ingrediente: {$ingrediente->nombre}",
            'id_admin' => auth()->id(),
        ]);

        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente creado correctamente.');
    }

    public function edit($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $categorias = [
            'Verduras y hortalizas', 'Carnes', 'Pescados y mariscos', 
            'Lácteos y huevos', 'Cereales y pasta', 'Aceites y condimentos', 'Otros'
        ];
        return view('admin.ingredientes.edit', compact('ingrediente', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $ingrediente = Ingrediente::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:150|unique:ingredientes,nombre,' . $id . ',id_ingrediente',
            'categoria' => 'required|string|max:150',
        ]);

        $ingrediente->update([
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'es_base' => $request->has('es_base'),
        ]);

        Actividad::create([
            'accion' => 'edit_ingrediente',
            'descripcion' => "Actualizado ingrediente: {$ingrediente->nombre}",
            'id_admin' => auth()->id(),
        ]);

        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $nombre = $ingrediente->nombre;
        
        $ingrediente->delete();

        Actividad::create([
            'accion' => 'delete_ingrediente',
            'descripcion' => "Eliminado ingrediente: {$nombre}",
            'id_admin' => auth()->id(),
        ]);

        return redirect()->route('admin.ingredientes.index')->with('success', 'Ingrediente eliminado correctamente.');
    }
}
