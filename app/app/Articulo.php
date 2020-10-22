<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Articulo extends Model
{
    protected $table = 'articulo';
    protected $primaryKey = 'idarticulo';
    public $timestamps = false;
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
    protected $guarded = [
    ];//aca los que no queremos que se agreguen al modelo

    /**
     * Devuelvo el articulo mas vendido en un período de tiempo
     * @param $fechaDesde
     * @param $fechaHasta
     * @return mixed
     */
    public static function masVendido($fechaDesde, $fechaHasta)
    {

        return Articulo::join('detalle_venta', 'detalle_venta.idarticulo', '=', 'articulo.idarticulo')
            ->join('venta', 'venta.idventa', '=', 'detalle_venta.idventa')
            ->select(
                DB::raw('articulo.descripcion'),
                DB::raw('articulo.nombre'),
                DB::raw('SUM(detalle_venta.cantidad) as cantidad')
            )
            ->where('venta.fecha_hora', '>=', $fechaDesde)
            ->where('venta.fecha_hora', '<=', $fechaHasta)
            ->groupBy('articulo.nombre', 'articulo.descripcion')
            ->orderBy('cantidad', 'desc')
            ->first();
    }
    public static function getAll($query) {
      return self::join('categoria as c','articulo.idcategoria','=','c.idcategoria')
                ->where ('articulo.nombre','LIKE','%'.$query.'%')//busca por nombre
                ->orWhere ('articulo.codigo','LIKE','%'.$query.'%')//o busca por codigo
                ->where('articulo.estado','=','Activo')
                ->orderBy('articulo.idarticulo','desc')//ordena de manera descendente
                ->select('articulo.idarticulo', 'articulo.nombre', 'articulo.codigo', 'c.nombre as categoria', 
                        'articulo.minStock', 'articulo.stock', 'articulo.imagen')
                ->paginate(10); //pagina de a 7 registros
  
    }

    
    
}
