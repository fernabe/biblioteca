<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario','id_libro', 'tipo','visto',
    ];
}

