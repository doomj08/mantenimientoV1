<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionFormato extends Model
{
    use HasFactory;

    protected $fillable=['seccion','formato_id','order'];

    public function CampoPropiedad() {
        return $this->hasMany('App\Models\CampoPropiedad');
        
    }
}
