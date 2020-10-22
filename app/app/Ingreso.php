<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ingreso extends Model
{
    protected $table = 'ingreso';
    protected $primaryKey = 'idingreso';
    public $timestamps = false;
    protected $fillable = [
        'idproveedor',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'estado'
    ];
    protected $guarded = [
    ];//aca los que no queremos que se agreguen al modelo

    public static function index(string $query)
    {
        return DB::table('ingreso as i')
            ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
            ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
            ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante',
                'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.num_comprobante', 'LIKE', '%' . $query . '%')
            ->orderBy('i.idingreso', 'desc')
            ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
            ->paginate(7);
    }

    public static function store(Http\Requests\IngresoFormRequest $request)
    {

        $ingreso = new self;
        $ingreso->idproveedor = $request->get('idproveedor');
        $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
        $ingreso->serie_comprobante = $request->get('serie_comprobante');
        $ingreso->num_comprobante = $request->get('num_comprobante');

        $mytime = Carbon::now('America/Argentina/Buenos_Aires');
        $ingreso->fecha_hora = $mytime->toDateTimeString();
        $ingreso->impuesto = '18';
        $ingreso->estado = 'A';
        $ingreso->save();

        $idarticulo = $request->get('idarticulo');
        $cantidad = $request->get('cantidad');
        $precio_compra = $request->get('precio_compra');

        $cont = 0;
        while ($cont < count($idarticulo)) {
            $detalle = new DetalleIngreso();
            $detalle->idingreso = $ingreso->idingreso;
            $detalle->idarticulo = $idarticulo[$cont];
            $detalle->cantidad = $cantidad[$cont];
            $detalle->precio_compra = $precio_compra[$cont];
            $detalle->save();
            $cont = $cont + 1;
        }
    }

    public static function showIngreso($id)
    {
        $ingreso = DB::table('ingreso as i')
            ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
            ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
            ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.idingreso', '=', $id)
            ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
            ->first();
        $detalles = DB::table('detalle_ingreso as d')
            ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
            ->select('a.nombre as articulo', 'd.cantidad', 'd.precio_compra')
            ->where('d.idingreso', '=', $id)
            ->get();

        return array_merge([
            'ingreso' => $ingreso,
            'detalles' => $detalles
        ]);
    }

    public static function desactivar($id)
    {
        $ingreso = self::findOrFail($id);
        $ingreso->Estado = 'C';
        $ingreso->update();
    }
}
