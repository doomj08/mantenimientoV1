<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class Recomendacion extends Model
{
    use HasFactory;

    protected $table="recomendaciones";

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        if(auth()->user())
            $empresa_id=auth()->user()->empresa_id;
        else
            $empresa_id=null;

    }
}
