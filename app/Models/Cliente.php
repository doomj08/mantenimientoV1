<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable=['nombre','tipo_documento','num_documento','contacto','correo','telefono','direccion','ciudad'];
}
