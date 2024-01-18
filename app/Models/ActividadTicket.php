<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class ActividadTicket extends Model
{
    use HasFactory;

    protected $fillable=[
        'ticket_id',
        'servicio_id',
        'fecha_hora',
        "estado_ticket",
        "descripcion",
        "tecnico_user_id"
    ];

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
        return $this->belongsTo('App\Models\Ticket');
    }

    public function TecnicoUser(){
        return $this->belongsTo('App\Models\User','tecnico_user_id');
    }
}
