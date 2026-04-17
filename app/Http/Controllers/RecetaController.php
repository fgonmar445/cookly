<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecetaController extends Controller
{
    /**
     * Buscar recetas en API externa (TheMealDB)
     */
    public function fromApi($nombre)
    {
        $response = Http::get("https://www.themealdb.com/api/json/v1/1/search.php?s=$nombre");

        $data = $response->json();

        return $data['meals'] ?? [];
    }

    /**
     * Guardar receta creada por usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string',
            'categoria' => 'nullable|string',
            'area' => 'nullable|string',
            'tags' => 'nullable|string',
            'youtube' => 'nullable|string',
        ]);

        $receta = Receta::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'categoria' => $request->categoria,
            'area' => $request->area,
            'tags' => $request->tags,
            'youtube' => $request->youtube,
            'origen' => 'usuario',
            'id_usuario' => auth()->id(),
        ]);

        return response()->json($receta);
    }

    /**
     * Guardar receta desde API (cuando el usuario la guarda o favoritos)
     */
    public function saveFromApi(Request $request)
    {
        $request->validate([
            'id_receta_api' => 'required|string',
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string',
            'categoria' => 'nullable|string',
            'area' => 'nullable|string',
            'tags' => 'nullable|string',
            'youtube' => 'nullable|string',
        ]);

        $receta = Receta::updateOrCreate(
            ['id_receta_api' => $request->id_receta_api],
            [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'imagen' => $request->imagen,
                'categoria' => $request->categoria,
                'area' => $request->area,
                'tags' => $request->tags,
                'youtube' => $request->youtube,
                'origen' => 'api',
                'id_usuario' => null,
            ]
        );

        return response()->json($receta);
    }

    /**
     * Listar recetas internas (usuarios)
     */
    public function index()
    {
        return Receta::where('origen', 'usuario')->get();
    }

    /**
     * Ver una receta (API o interna)
     */
    public function show($id)
    {
        return Receta::findOrFail($id);
    }

    /**
     * Buscar recetas internas
     */
    public function search($nombre)
    {
        return Receta::where('nombre', 'like', "%$nombre%")->get();
    }
}
