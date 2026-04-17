<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ingrediente;

class ListaIngrediente extends Model
{
    protected $table = 'lista_ingredientes';
    protected $primaryKey = 'id_lista';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_ingrediente',
        'fecha_guardado'
    ];

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con ingrediente
    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'id_ingrediente');
    }
}
