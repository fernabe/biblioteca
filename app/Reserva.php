<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario','id_libro', 'fecha_reserva','fin_reserva',
    ];
}
