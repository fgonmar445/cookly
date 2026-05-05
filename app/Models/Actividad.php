<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividad';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'accion',
        'descripcion',
        'id_admin',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
