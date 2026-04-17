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

    /**
     * Usuario propietario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Ingrediente asociado
     */
    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'id_ingrediente', 'id_ingrediente');
    }
}
