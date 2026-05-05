<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Ingrediente;
use App\Models\Favorito;
use App\Models\ListaIngrediente;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'lista_ingredientes',
            'id_usuario',
            'id_ingrediente'
        );
    }

    public function listaIngredientes()
    {
        return $this->hasMany(ListaIngrediente::class, 'id_usuario');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_usuario');
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'id_usuario');
    }
}
