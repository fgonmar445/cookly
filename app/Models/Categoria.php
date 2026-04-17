<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ingrediente;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    /**
     * Relación N:M con Ingredientes
     */
    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'ingrediente_categoria',
            'id_categoria',
            'id_ingrediente'
        );
    }
}
