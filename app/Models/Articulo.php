<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $fillable=["nombre_interno","tipo_articulo_id","cliente_id"];

    public function Propiedad(){
        return $this->hasMany('App\Models\Propiedad');
    }

    public function Componente(){
        return $this->hasMany('App\Models\Articulo','articulo_padre_id');
    }

    public function TipoArticulo(){
        return $this->belongsTo('App\Models\TipoArticulo');
    }
}
