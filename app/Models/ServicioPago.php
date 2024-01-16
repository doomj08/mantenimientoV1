<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioPago extends Model
{
    use HasFactory;

    protected $fillable=['servicio_id','fecha','tipo_pago','referencia','concepto','valor'];

}
