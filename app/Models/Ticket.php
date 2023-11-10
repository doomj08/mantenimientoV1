<?php

namespace App\Models;

use App\Models\Scopes\TicketScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    use HasFactory;
    
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new TicketScope);
        $empresa_id=auth()->user()->empresa_id;

    }

    protected $fillable=['num_ticket','empresa_id','register_user_id','descripcion','cliente_id','fecha_hora'];
    protected $appends = ['estado-ticket'];

    public function Cliente(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function Empresa(){
        return $this->belongsTo('App\Models\Empresa');
    }

    public function RegisterUser(){
        return $this->belongsTo('App\Models\User','register_user_id');
    }

    public function Servicio(){
        return $this->hasMany('App\Models\Servicio');
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
