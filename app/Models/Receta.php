<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ingrediente;
use App\Models\Favorito;

class Receta extends Model
{
    protected $table = 'receta';
    protected $primaryKey = 'id_receta_api';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_receta_api',
        'nombre',
        'descripcion',
        'imagen',
        'categoria',
        'area',
        'tags',
        'youtube'
    ];

    // Ingredientes de la receta (N:M)
    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'receta_ingrediente',
            'id_receta_api',
            'id_ingrediente'
        )->withPivot('cantidad');
    }

    // Favoritos
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_receta_api');
    }
}
