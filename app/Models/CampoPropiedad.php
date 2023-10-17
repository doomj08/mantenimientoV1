<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampoPropiedad extends Model
{
    use HasFactory;
    protected $table = "campos_propiedades";

    protected $fillable=['nombre_propiedad','tipo_articulo_id','seccion_formato_id'];
}
