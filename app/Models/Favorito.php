<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Receta;

class Favorito extends Model
{
    protected $table = 'favoritos';
    protected $primaryKey = 'id_favorito';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_receta',
        'fecha_guardado'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'id_receta');
    }
}
