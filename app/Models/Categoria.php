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

    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'alimento_categoria',
            'id_categoria',
            'id_alimento'
        );
    }
}
