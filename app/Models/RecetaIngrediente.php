<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaIngrediente extends Model
{
    protected $table = 'receta_ingrediente';
    public $timestamps = false;

    protected $fillable = [
        'id_receta_api',
        'id_ingrediente',
        'cantidad'
    ];
}
