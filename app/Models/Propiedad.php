<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = "propiedades";

    protected $fillable = ['empresa_id','campo_propiedad_id','propiedad','articulo_id','visible'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        if(auth()->user())
            $empresa_id=auth()->user()->empresa_id;
        else
            $empresa_id=null;

    }

    public function CampoPropiedad(){
        return $this->belongsTo('App\Models\CampoPropiedad');
    }
}
