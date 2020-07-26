<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    protected $table='venta';
    protected $primaryKey='idventa';
    public $timestamps=false;
    protected $fillable = [
    	'idcliente',
    	'tipo_comprobante',
    	'serie_comprobante',
    	'num_comprobante',
    	'fecha_hora',
		'impuesto',
    	'total_venta',
    	'estado'
    ]; 
    protected $guarded =[
    ];//aca los que no queremos que se agreguen al modelo

    public static function ventasPorMes(){
        return Venta::join('detalle_venta','detalle_venta.idventa','=','venta.idventa')
            ->join('articulo','articulo.idarticulo','=','detalle_venta.idarticulo')
            ->select(
                DB::raw('month(venta.fecha_hora) mes'),
                DB::raw('COUNT(venta.idventa) as ventas'),
                DB::raw('SUM(venta.total_venta) as total')
            )
            ->groupBy('mes')
            ->get();
    }
}
