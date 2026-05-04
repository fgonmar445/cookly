<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavoritoController extends Controller
{
    /**
     * Listar favoritos del usuario logueado
     */
    public function index()
    {

        $user = auth()->user();

        // Obtener favoritos del usuario
        $favoritos = $user->favoritos()->get();


        $resultado = [];

        foreach ($favoritos as $fav) {

            // Buscar la receta en tu BD
            $receta = Receta::where('id_receta', $fav->id_receta)->first();

            // Si no existe, saltar
            if (!$receta) continue;

            $resultado[] = [
                'id_favorito' => $fav->id_favorito,
                'id_receta' => $receta->id_receta,
                'id_receta_api' => $receta->id_receta_api,
                'nombre' => $receta->nombre,
                'imagen' => $receta->imagen,
                'categoria' => $receta->categoria,
                'area' => $receta->area,
                'id_usuario' => $receta->id_usuario,
            ];
        }

        return response()->json($resultado);
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

    public function toggle(Request $request, $id)
    {
        $user = auth()->user();

        // 1. Buscar si la receta ya estÃ¡ en tu BD
        $receta = Receta::where('id_receta_api', $id)->first();

        if (!$receta && is_numeric($id)) {
            $receta = Receta::find($id);
        }

        // 2. Si no existe, traerla de la API y guardarla
        if (!$receta) {
            // Intentar lookup normal
            $response = Http::get("https://www.themealdb.com/api/json/v2/1/lookup.php?i={$id}");
            $data = null;
            
            if ($response->successful()) {
                $data = $response->json()['meals'][0] ?? null;
            }

            // FALLBACK: Si lookup falla hoy en TheMealDB, buscamos por nombre
            if (!$data && $request->has('name')) {
                $name = $request->input('name');
                $fallbackResponse = Http::get("https://www.themealdb.com/api/json/v2/1/search.php?s=$name");
                if ($fallbackResponse->successful()) {
                    $meals = $fallbackResponse->json()['meals'] ?? [];
                    foreach ($meals as $m) {
                        if ($m['idMeal'] == $id) {
                            $data = $m;
                            break;
                        }
                    }
                }
            }

            if (!$data) {
                return back()->with('error', 'No se pudo obtener la receta de la API (Servicio externo con problemas)');
            }

            // Guardar receta en tu BD
            $receta = Receta::create([
                'id_receta_api' => $data['idMeal'],
                'nombre' => $data['strMeal'],
                'descripcion' => $data['strInstructions'],
                'imagen' => $data['strMealThumb'],
                'categoria' => $data['strCategory'],
                'area' => $data['strArea'],
                'tags' => $data['strTags'],
                'youtube' => $data['strYoutube'],
                'origen' => 'api',
                'id_usuario' => null,
            ]);
        }

        // 3. Ahora sí: usar el ID interno de tu BD
        $idInterno = $receta->id_receta;

        // 4. Comprobar si ya es favorito
        $favorito = Favorito::where('id_usuario', $user->id)
            ->where('id_receta', $idInterno)
            ->first();

        if ($favorito) {
            $favorito->delete();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'isFavorito' => false]);
            }
            return back()->with('success', 'Receta eliminada de favoritos');
        }

        // 5. Crear favorito
        Favorito::create([
            'id_usuario' => $user->id,
            'id_receta' => $idInterno,
            'fecha_guardado' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'isFavorito' => true]);
        }

        return back()->with('success', 'Receta añadida a favoritos');
    }
}
