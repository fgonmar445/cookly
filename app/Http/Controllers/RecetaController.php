<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecetaController extends Controller
{


    public function create()
    {
        $ingredientes = \App\Models\Ingrediente::whereNotNull('categoria')
            ->orderBy('categoria')
            ->orderBy('nombre')
            ->get()
            ->groupBy('categoria');

        return view('recetas.create', compact('ingredientes'));
    }

    public function edit($id)
    {
        $receta = Receta::where('id_receta', $id)
            ->where('id_usuario', auth()->id())
            ->firstOrFail();

        $ingredientes = \App\Models\Ingrediente::whereNotNull('categoria')
            ->orderBy('categoria')
            ->orderBy('nombre')
            ->get()
            ->groupBy('categoria');

        return view('recetas.editar', compact('receta', 'ingredientes'));
    }

    public function update(Request $request, $id)
    {
        $receta = Receta::where('id_receta', $id)
            ->where('id_usuario', auth()->id())
            ->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:200',
            'categoria' => 'nullable|string|max:200',
            'cocina' => 'nullable|string|max:200',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'cocina' => $request->cocina,
        ];

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('recetas', 'public');
            $data['imagen'] = "/storage/" . $rutaImagen;
        }

        $receta->update($data);

        // Actualizar ingredientes
        if ($request->has('ingredientes_ids')) {
            $ids = $request->input('ingredientes_ids');
            $cantidades = $request->input('cantidades');
            
            $syncData = [];
            foreach ($ids as $index => $id_ing) {
                if (!empty($id_ing)) {
                    $syncData[$id_ing] = ['cantidad' => $cantidades[$index] ?? ''];
                }
            }
            
            $receta->ingredientes()->sync($syncData);
        } else {
            // Si se envían cero ingredientes (se vació la lista)
            $receta->ingredientes()->sync([]);
        }

        return redirect()->route('recetas.mias')->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $receta = Receta::where('id_receta', $id)
            ->where('id_usuario', auth()->id())
            ->firstOrFail();

        $receta->delete();

        return redirect()->route('recetas.mias')->with('success', 'Receta eliminada');
    }


    public function misRecetas()
    {
        $recetas = Receta::where('id_usuario', auth()->id())
            ->orderBy('id_receta', 'desc')
            ->get();

        return view('recetas.mis_recetas', compact('recetas'));
    }

    public function recetasUsuarios()
    {
        $recetas = Receta::whereNotNull('id_usuario')
            ->orderBy('created_at', 'desc')
            ->paginate(12); // o ->take(20)->get(); si no quieres paginación

        return view('recetas.usuarios', compact('recetas'));
    }



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
            'categoria' => 'nullable|string|max:200',
            'cocina' => 'nullable|string|max:200',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        // Subir imagen si existe
        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('recetas', 'public');
            // Si usamos almacenamiento público, queremos la URL completa o relativa correcta
            $rutaImagen = "/storage/" . $rutaImagen;
        }

        // Guardar receta
        $receta = Receta::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen,
            'categoria' => $request->categoria,
            'cocina' => $request->cocina,
            'tags' => null,
            'youtube' => null,
            'origen' => 'usuario',
            'id_usuario' => auth()->id(),
        ]);

        // Guardar ingredientes
        if ($request->has('ingredientes_ids')) {
            $ids = $request->input('ingredientes_ids');
            $cantidades = $request->input('cantidades');
            
            $syncData = [];
            foreach ($ids as $index => $id_ing) {
                if (!empty($id_ing)) {
                    $syncData[$id_ing] = ['cantidad' => $cantidades[$index] ?? ''];
                }
            }
            
            $receta->ingredientes()->sync($syncData);
        }

        return redirect()
            ->route('recetas.mias')
            ->with('success', 'Receta creada correctamente.');
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
            'cocina' => 'nullable|string',
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
                'cocina' => $request->cocina,
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
                'strArea' => $recetaBD->cocina, // for API compatibility in views
                'strTags' => $recetaBD->tags,
                'strYoutube' => $recetaBD->youtube,
            ];

            // Ingredientes
            $localIngredientes = $recetaBD->ingredientes;
            for ($i = 1; $i <= 20; $i++) {
                $ing = $localIngredientes[$i-1] ?? null;
                $receta["strIngredient{$i}"] = $ing ? $ing->nombre : null;
                $receta["strMeasure{$i}"] = $ing ? $ing->pivot->cantidad : null;
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

                // Traducir ingredientes de la API
                if ($receta) {
                    $map = config('ingredients.en_to_es');
                    for ($i = 1; $i <= 20; $i++) {
                        if (!empty($receta["strIngredient{$i}"])) {
                            $enIng = strtolower($receta["strIngredient{$i}"]);
                            if (isset($map[$enIng])) {
                                $receta["strIngredient{$i}"] = ucfirst($map[$enIng]);
                            }
                        }
                    }
                    // También traducir categoría y área si están en el mapa
                    $catMap = config('ingredients.categorias');
                    $cocinaMap = config('ingredients.cocinas');
                    if (isset($receta['strCategory'])) {
                        $enCat = strtolower($receta['strCategory']);
                        if (isset($catMap[$enCat])) $receta['strCategory'] = ucfirst($catMap[$enCat]);
                    }
                    if (isset($receta['strArea'])) {
                        $enCocina = strtolower($receta['strArea']);
                        if (isset($cocinaMap[$enCocina])) $receta['strArea'] = ucfirst($cocinaMap[$enCocina]);
                    }
                }

                // FALLBACK... (rest of the code)

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

        return view('recetas.show', compact('receta', 'isFavorita', 'recetaBD'));
    }





    /**
     * Buscar recetas internas
     */
    public function search($nombre)
    {
        return Receta::where('nombre', 'like', "%$nombre%")->get();
    }
}
