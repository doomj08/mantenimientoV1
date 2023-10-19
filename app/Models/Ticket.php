<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable=['descripcion','cliente_id'];

    protected $appends = ['estado-ticket'];

    public function Cliente(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function ActividadTicket(){
        return $this->hasMany('App\Models\ActividadTicket');
    }

    public function TicketArticulo(){
        return $this->belongsToMany('App\Models\Articulo','ticket_articulos');
    }

    public function getEstadoTicketAttribute(){
        return  $this->ActividadTicket()->where('estado_ticket','cerrado')->count();
    }
}
