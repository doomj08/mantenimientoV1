<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    public function Recomendacion(){
        return $this->hasMany('App\Models\Recomendacion');
    }

    public function ServicioArticulos(){
        return $this->belongsToMany('App\Models\Articulo','servicio_articulos');
    }


}
