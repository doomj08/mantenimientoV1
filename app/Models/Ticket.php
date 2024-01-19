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
        if(auth()->user())
            $empresa_id=auth()->user()->empresa_id;
        else
            $empresa_id=null;

    }

    protected $fillable=['num_ticket','empresa_id','register_user_id','descripcion','cliente_id','fecha_hora','fecha_estimada'];
    protected $appends = ['estado-ticket','min-tiempo-inicial','max-tiempo-final'];

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

    public function Recomendaciones(){
        return $this->hasMany('App\Models\TicketRecomendacion');
    }

    public function TicketArticulo(){
        return $this->belongsToMany('App\Models\Articulo','ticket_articulos');
    }

    public function getEstadoTicketAttribute(){
        $count_servicios=$this->Servicio()->count();
        if($count_servicios>0){
            return  ($this->ActividadTicket()->where('estado_ticket','abierto')->count()>0)?'Abierto':'Cerrado';
        }else{
            return 'Abierto';
        }

        
    }

    public function getMinTiempoInicialAttribute(){
        return $this->Servicio()->min('fecha_inicio');
    }

    public function getMaxTiempoFinalAttribute(){
        return $this->Servicio()->max('fecha_fin');
    }
}
