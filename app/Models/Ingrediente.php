<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Receta;
use App\Models\Categoria;

class Ingrediente extends Model
{
    protected $table = 'ingredientes';
    protected $primaryKey = 'id_ingrediente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'tipo'
    ];

    // Relación con usuarios (N:M)
    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'lista_ingredientes',
            'id_ingrediente',
            'id_usuario'
        );
    }

    // Relación con recetas (N:M)
    public function recetas()
    {
        return $this->belongsToMany(
            Receta::class,
            'receta_ingrediente',
            'id_ingrediente',
            'id_receta'
        )->withPivot('cantidad');
    }

    // Relación con categorías (N:M)
    public function categorias()
    {
        return $this->belongsToMany(
            Categoria::class,
            'ingrediente_categoria',
            'id_ingrediente',
            'id_categoria'
        );
    }
}
