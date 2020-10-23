<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'idventa';
    public $timestamps = false;
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

    protected $guarded = [
    ];//aca los que no queremos que se agreguen al modelo

    public static function ventasPorMes()
    {
        return self::join('detalle_venta', 'detalle_venta.idventa', '=', 'venta.idventa')
            ->join('articulo', 'articulo.id', '=', 'detalle_venta.idarticulo')
            ->select(
                DB::raw('month(venta.fecha_hora) mes'),
                DB::raw('COUNT(venta.idventa) as ventas'),
                DB::raw('SUM(venta.total_venta) as total')
            )
            ->groupBy('mes')
            ->get();
    }

    public static function ventaPorCliente($id)
    {
        return DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where('v.idcliente', '=', $id)
            ->orderBy('v.idventa', 'desc')
            ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->paginate(7);
    }

    public static function getVenta($id)
    {
        $venta = DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta', 'v.idcliente', 'v.info_afip')
            ->where('v.idventa', '=', $id)
            ->first();

        $detalles = DB::table('detalle_venta as d')
            ->join('articulo as a', 'd.idarticulo', '=', 'a.id')
            ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_venta')
            ->where('d.idventa', '=', $id)
            ->get();
        return array_merge([
            'venta' => $venta,
            'detalles' => $detalles
        ]);
    }

    public static function getVentas(string $query, string $query2)
    {
        $ventas = DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'p.nombre', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where([['p.nombre', 'LIKE', '%' . $query . '%'], ['v.fecha_hora', 'LIKE', '%' . $query2 . '%']])
            ->orderBy('v.idventa', 'desc')
            ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->paginate(7);
        $total = DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->where([['p.nombre', 'LIKE', '%' . $query . '%'], ['v.fecha_hora', 'LIKE', '%' . $query2 . '%']])
            ->count('v.idventa');
        return array_merge([
            'ventas' => $ventas,
            'total' => $total
        ]);
    }

    public static function getNumeroVenta()
    {
        $venta = DB::table('venta as v')->select('v.num_comprobante')->orderBy('v.num_comprobante', 'desc')->first();
        if ($venta == null) {
            $num = 1;
        } else {
            $num = $venta->num_comprobante;
            $num = $num + 1;
        };

        return $num;
    }

    public static function guardarVenta(Http\Requests\VentaFormRequest $request)
    {
        $articulosGuardados = [];

        try {
            DB::beginTransaction();
            $venta = new self;
            $venta->idcliente = $request->get('idcliente');
            $venta->tipo_comprobante = $request->get('tipo_comprobante');
            $venta->serie_comprobante = $request->get('serie_comprobante');
            $venta->num_comprobante = $request->get('num_comprobante');
            $venta->total_venta = $request->get('total_venta');

            $mytime = Carbon::now('America/Argentina/Buenos_Aires');
            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->impuesto = '18';
            $venta->estado = 'A';
            $venta->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_venta');
            $cont = 0;

            while ($cont < count($idarticulo)) {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->idventa;
                $detalle->idarticulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
                array_push($articulosGuardados, $detalle->idarticulo);
            }
            DB::commit();
            return $venta;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public static function desactivar($id)
    {
        $venta = self::findOrFail($id);
        $venta->Estado = 'C';
        $venta->update();
    }
}
