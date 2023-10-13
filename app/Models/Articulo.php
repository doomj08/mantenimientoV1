<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    public function Propiedad(){
        return $this->hasMany('App\Models\Propiedad');
    }

    public function Componente(){
        return $this->hasMany('App\Models\Articulo','articulo_padre_id');
    }
}
