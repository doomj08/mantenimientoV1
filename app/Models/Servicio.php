<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ActiveScope;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable=['empresa_id','ticket_id','user_id','descripcion','fecha_programada','fecha_inicio','fecha_fin','precio','tiene_iva'];

    protected $appends = ['estado-servicio','pago-total','count-pagos'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        if(auth()->user())
            $empresa_id=auth()->user()->empresa_id;
        else
            $empresa_id=null;

    }

    public function Recomendacion(){
        return $this->hasMany('App\Models\Recomendacion');
    }

    public function ServicioArticulos(){
        return $this->belongsToMany('App\Models\Articulo','servicio_articulos');
    }

    public function Actividades(){
        return $this->hasMany('App\Models\ActividadTicket');
    }

    public function Pagos(){
        return $this->hasMany('App\Models\ServicioPago');
    }



    public function Ticket() {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function getEstadoServicioAttribute(){
        return  $this->Actividades()->where('estado_ticket','cerrado')->count();
    }

    public function getCountPagosAttribute(){
        return $this->Pagos()->count('valor');
    }

    public function getPagoTotalAttribute(){
        return $this->Pagos()->sum('valor');
    }








}
