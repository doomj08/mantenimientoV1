<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;

    public function Articulo(){
        return $this->belongsTo('App\Models\Articulo');
    }
}
