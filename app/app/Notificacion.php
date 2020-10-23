<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $fillable=['msj','visto'];
    protected $table='notificaciones';
    public $timestamps = false;
}
