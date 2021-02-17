<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Unidad extends Model
{
    //com
    protected $table = 'tbl_unidades';

    protected $fillable = [
        'id','unidad','cct','dunidad','dgeneral','plantel','academico','vinculacion','dacademico','pdgeneral',
        'pdacademico', 'pdunidad', 'pacademico', 'pvinculacion', 'jcyc', 'pjcyc', 'ubicacion','direccion',
        'telefono','correo','coordenadas','codigo_postal'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->hasMany(User::class, 'id');
    }
}
