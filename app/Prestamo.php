<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario','id_libro', 'fecha_prestamo','fin_prestamo', 'renovaciones'
    ];
}
