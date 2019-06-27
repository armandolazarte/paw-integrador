<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaPersona extends Model
{
    protected $table='categoria_persona';
    protected $primaryKey='idcategoria_persona';
    public $timestamps=false;
    protected $fillable = [
    	'idcategoria_persona',
    	'nombre'
    ]; 
    protected $guarded =[
    ];//aca los que no queremos que se agreguen al modelo
}
