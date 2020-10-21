<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table='articulo';
    protected $primaryKey='idarticulo';
    public $timestamps=false;
    protected $fillable = [
    	'idcategoria',
    	'codigo',
    	'nombre',
    	'stock',
    	'descripcion',
    	'imagen',
    	'estado',
      'minStock'
    ];
    protected $guarded =[
    ];//aca los que no queremos que se agreguen al modelo

    public static function getAll($query) {
      return self::join('categoria as c','articulo.idcategoria','=','c.idcategoria')
                ->select('articulo.minStock','articulo.idarticulo','articulo.nombre','articulo.codigo','articulo.stock','c.nombre as categoria','articulo.descripcion','articulo.imagen','articulo.estado')
                ->where ('articulo.nombre','LIKE','%'.$query.'%')//busca por nombre
                ->orWhere ('articulo.codigo','LIKE','%'.$query.'%')//o busca por codigo
                ->where('articulo.estado','=','Activo')
                ->orderBy('articulo.idarticulo','desc')//ordena de manera descendente
                ->paginate(10); //pagina de a 7 registros
  
    }

    
    
}
