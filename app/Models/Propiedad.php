<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = "propiedades";

    public function CampoPropiedad(){
        return $this->belongsTo('App\Models\CampoPropiedad');
    }
}
