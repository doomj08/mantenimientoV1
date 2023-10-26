<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable=['ticket_id','user_id','descripcion','fecha_programada','fecha_inicio','fecha_fin','precio'];

    public function Recomendacion(){
        return $this->hasMany('App\Models\Recomendacion');
    }

    public function ServicioArticulos(){
        return $this->belongsToMany('App\Models\Articulo','servicio_articulos');
    }

    public function Actividades(){
        return $this->hasMany('App\Models\ActividadTicket');
    }

    public function Ticket() {
        return $this->belongsTo('App\Models\Ticket');
    }


}
