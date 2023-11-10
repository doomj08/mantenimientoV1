<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaDigitalizada extends Model
{
    use HasFactory;

    protected $fillable = [
        'firma_digital','user_id'
    ];
}
