<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Receta;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalRecipes = Receta::count();
        $recipesThisWeek = Receta::where('created_at', '>=', now()->startOfWeek())->count();
        $totalFavorites = DB::table('favoritos')->count();

        $latestUsers = User::latest()->take(5)->get();
        $latestRecipes = Receta::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRecipes',
            'recipesThisWeek',
            'totalFavorites',
            'latestUsers',
            'latestRecipes'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->withCount(['favoritos', 'recetas'])
                       ->latest()
                       ->paginate(10);

        // For "cuántas recetas ha creado cada usuario", we need to count recipes where id_usuario = user.id
        // Since Receta model uses 'id_usuario', let's check if there's a relationship in User model.
        // I'll add it if it doesn't exist.
        
        return view('admin.users', compact('users'));
    }

    public function recipes(Request $request)
    {
        $query = Receta::query()->where('origen', 'usuario');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('nombre', 'like', "%{$search}%");
        }

        $recipes = $query->with('usuario')
                         ->latest()
                         ->paginate(10);

        return view('admin.recipes', compact('recipes'));
    }

    public function logs()
    {
        $logs = ActivityLog::with('admin')->latest()->paginate(20);
        return view('admin.logs', compact('logs'));
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $userName = $user->name;
        $userEmail = $user->email;

        $user->delete();

        ActivityLog::create([
            'action' => 'delete_user',
            'description' => "Eliminado usuario: {$userName} ({$userEmail})",
            'admin_id' => auth()->id(),
        ]);

        return back()->with('success', 'Usuario eliminado correctamente.');
    }

    public function deleteRecipe(Receta $recipe)
    {
        $recipeName = $recipe->nombre;
        $creatorName = $recipe->usuario ? $recipe->usuario->name : 'Desconocido';

        $recipe->delete();

        ActivityLog::create([
            'action' => 'delete_recipe',
            'description' => "Eliminada receta: {$recipeName} (Creada por: {$creatorName})",
            'admin_id' => auth()->id(),
        ]);

        return back()->with('success', 'Receta eliminada correctamente.');
    }

    public function changeRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $oldRole = $user->rol;
        $newRole = $request->input('rol');

        $user->update(['rol' => $newRole]);

        ActivityLog::create([
            'action' => 'change_role',
            'description' => "Cambiado rol de {$user->name}: {$oldRole} -> {$newRole}",
            'admin_id' => auth()->id(),
        ]);

        return back()->with('success', "Rol de {$user->name} actualizado a {$newRole}.");
    }
}
