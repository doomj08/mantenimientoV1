<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;

    protected $fillable=['articulo_id','formato_id'];

    public function Articulo(){
        return $this->belongsTo('App\Models\Articulo');
    }
}
