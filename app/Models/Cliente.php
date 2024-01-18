<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable=['empresa_id','nombre','tipo_documento','num_documento','contacto','correo','telefono','direccion','ciudad'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        if(auth()->user())
            $empresa_id=auth()->user()->empresa_id;
        else
            $empresa_id=null;

    }

    public function Ticket(){
        return $this->hasMany('App\Models\Ticket');
    }
}
