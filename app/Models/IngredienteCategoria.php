<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredienteCategoria extends Model
{
    protected $table = 'ingrediente_categoria';

    public $timestamps = false;

    protected $fillable = [
        'id_ingrediente',
        'id_categoria'
    ];

    /**
     * Relación con Ingrediente
     */
    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'id_ingrediente', 'id_ingrediente');
    }

    /**
     * Relación con Categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
