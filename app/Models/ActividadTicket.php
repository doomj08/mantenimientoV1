<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class ActividadTicket extends Model
{
    use HasFactory;

    protected $fillable=[
        'empresa_id',
        'ticket_id',
        'servicio_id',
        'fecha_hora',
        "estado_ticket",
        'fecha_cierre',
        "descripcion",
        "tecnico_user_id"
    ];



    public function Ticket(){
        return $this->belongsTo('App\Models\Ticket');
    }

    public function TecnicoUser(){
        return $this->belongsTo('App\Models\User','tecnico_user_id');
    }
}
