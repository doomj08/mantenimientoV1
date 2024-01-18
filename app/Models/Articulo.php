<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class Articulo extends Model
{
    use HasFactory;

    protected $fillable=['empresa_id',"nombre_interno","tipo_articulo_id","cliente_id","articulo_padre_id"];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        if(auth()->user())
            $empresa_id=auth()->user()->empresa_id;
        else
            $empresa_id=null;

    }

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
