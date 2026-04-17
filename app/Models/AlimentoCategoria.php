<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlimentoCategoria extends Model
{
    protected $table = 'alimento_categoria';
    public $timestamps = false;

    protected $fillable = [
        'id_alimento',
        'id_categoria'
    ];
}
