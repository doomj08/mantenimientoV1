<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class Informe extends Model
{
    use HasFactory;

    protected $fillable=['empresa_id','articulo_id','formato_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        if(auth()->user())
            $empresa_id=auth()->user()->empresa_id;
        else
            $empresa_id=null;

    }

    public function Articulo(){
        return $this->belongsTo('App\Models\Articulo');
    }

    public function Formato(){
        return $this->belongsTo('App\Models\Formato');
    }
}
