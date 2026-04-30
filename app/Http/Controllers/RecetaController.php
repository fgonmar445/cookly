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
        $response = Http::get("https://www.themealdb.com/api/json/v2/1/search.php?s=$nombre");

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
            'id_usuario' => $request->user()->id,
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
    public function show(Request $request, $id)
    {
        // 1. Intentar buscar en tu BD por id_receta_api o por id local
        $recetaBD = Receta::where('id_receta_api', $id)->first();

        if (!$recetaBD && is_numeric($id)) {
            $recetaBD = Receta::find($id);
        }

        if ($recetaBD) {
            // Convertir modelo a array con el MISMO formato que la API
            $receta = [
                'idMeal' => $recetaBD->id_receta_api ?? $recetaBD->id_receta,
                'strMeal' => $recetaBD->nombre,
                'strInstructions' => $recetaBD->descripcion,
                'strMealThumb' => $recetaBD->imagen,
                'strCategory' => $recetaBD->categoria,
                'strArea' => $recetaBD->area,
                'strTags' => $recetaBD->tags,
                'strYoutube' => $recetaBD->youtube,
            ];

            // Ingredientes vacíos (tu BD no los guarda individualmente en este modelo)
            for ($i = 1; $i <= 20; $i++) {
                $receta["strIngredient{$i}"] = null;
                $receta["strMeasure{$i}"] = null;
            }
        } else {
            // 2. Si no existe en BD, traerla de la API
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                ])->get("https://www.themealdb.com/api/json/v2/1/lookup.php?i={$id}");

                $receta = null;

                if ($response->successful()) {
                    $receta = $response->json()['meals'][0] ?? null;
                }

                // FALLBACK: Si lookup falla (TheMealDB suele dar 500 hoy), intentamos buscar por nombre si se pasÃ³ en la URL
                if (!$receta && $request->has('name')) {
                    $name = $request->query('name');
                    $fallbackResponse = Http::get("https://www.themealdb.com/api/json/v2/1/search.php?s=$name");
                    if ($fallbackResponse->successful()) {
                        $meals = $fallbackResponse->json()['meals'] ?? [];
                        foreach ($meals as $m) {
                            if ($m['idMeal'] == $id) {
                                $receta = $m;
                                break;
                            }
                        }
                    }
                }

                if (!$receta) {
                    if ($response->failed()) {
                        abort(503, "El servicio externo de recetas (TheMealDB) tiene problemas temporales. Intenta de nuevo en unos minutos.");
                    }
                    abort(404, "Receta no encontrada");
                }
            } catch (\Exception $e) {
                abort(500, "Error de conexiÃ³n con el servicio de recetas: " . $e->getMessage());
            }
        }

        // 3. Comprobar si es favorita
        $isFavorita = false;
        if ($recetaBD) {
            $isFavorita = auth()->user()
                ->favoritos()
                ->where('id_receta', $recetaBD->id_receta)
                ->exists();
        }

        return view('recetas.show', compact('receta', 'isFavorita'));
    }





    /**
     * Buscar recetas internas
     */
    public function search($nombre)
    {
        return Receta::where('nombre', 'like', "%$nombre%")->get();
    }
}
