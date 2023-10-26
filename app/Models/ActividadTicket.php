<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadTicket extends Model
{
    use HasFactory;

    protected $fillable=[
        'ticket_id',
        'servicio_id',
        'fecha_hora',
        "estado_ticket",
        "descripcion"
    ];

    public function Ticket(){
        return $this->belongsTo('App\Models\Ticket');
    }
}
