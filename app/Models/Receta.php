<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ingrediente;
use App\Models\Favorito;

class Receta extends Model
{
    protected $table = 'recetas';
    protected $primaryKey = 'id_receta';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_receta_api',
        'nombre',
        'descripcion',
        'imagen',
        'categoria',
        'area',
        'tags',
        'youtube',
        'origen',
        'id_usuario'
    ];

    // Relación con el usuario que creó la receta
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Ingredientes de la receta (N:M)
    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'receta_ingrediente',
            'id_receta',
            'id_ingrediente'
        )->withPivot('cantidad');
    }

    // Favoritos
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_receta');
    }
}
