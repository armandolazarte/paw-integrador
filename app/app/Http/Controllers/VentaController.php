<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\NotificacionAdmin;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use App\DetalleVenta;
use DB;
use Carbon\Carbon;
use Illuminate\View\View;
use Response;
use Illuminate\Support\Collection;
use PDF;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function imprimir($id)
    {
        $venta = DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where('v.idventa', '=', $id)
            ->first();

        $detalles = DB::table('detalle_venta as d')
            ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
            ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_compra', 'd.mano_obra')
            ->where('d.idventa', '=', $id)
            ->get();
        $total = 0;
        foreach ($detalles as $det) {
            $subtotal = $det->cantidad * $det->precio_compra - $det->descuento;
            $total += $subtotal;
        };
        $pdf = new PDF();
        $date = date('d/m/Y');
        $view = \Illuminate\Support\Facades\View::make('pdfs.venta', ['detalles' => $detalles, 'total' => $total, 'fecha' => $date, 'venta' => $venta, 'tipo' => 'ORIGINAL']);
        $html = $view->render();
        $pdf::addPage('P', 'LEGAL');
        $pdf::writeHTML($html, true, false, true, false, '');
        $view = \Illuminate\Support\Facades\View::make('pdfs.venta', ['detalles' => $detalles, 'total' => $total, 'fecha' => $date, 'venta' => $venta, 'tipo' => 'COPIA']);
        $html = $view->render();
        $pdf::addPage('P', 'LEGAL');
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('venta.pdf', 'I');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $query2 = trim($request->get('searchText2'));
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
                //->join('detalle_venta as dv','v.idventa','=','dv.idventa')
                ->where([['p.nombre', 'LIKE', '%' . $query . '%'], ['v.fecha_hora', 'LIKE', '%' . $query2 . '%']])
                ->count('v.idventa') //hay que completar el target
            ;
            return view('ventas.venta.index', ["ventas" => $ventas, "searchText" => $query, "searchText2" => $query2, "total" => $total]);

        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona', '=', 'Cliente')->get();
        $articulos = DB::table('articulo as art')
            ->join('detalle_ingreso as di', 'art.idarticulo', '=', 'di.idarticulo')
            ->join('categoria as c', 'art.idcategoria', '=', 'c.idcategoria')
            ->select(DB::raw('CONCAT(c.nombre," | ",art.nombre) AS articulo'), 'art.idarticulo', 'art.stock', DB::raw('max(di.precio_venta) as precio_promedio'))
            ->where('art.estado', '=', 'Activo')
            ->where('art.stock', '>', '0')
            ->groupBy('articulo', 'art.idarticulo', 'art.stock')
            ->get();
        $venta = DB::table('venta as v')->select('v.num_comprobante')->orderBy('v.num_comprobante', 'desc')->first();
        if ($venta == null) {
            $num = 1;
        } else {
            $num = $venta->num_comprobante;
            $num = $num + 1;
        };
        return view("ventas.venta.create", ["personas" => $personas, "articulos" => $articulos, "num_comprobante" => $num]);
    }

    public function store(VentaFormRequest $request)
    {
        $articulosGuardados = [];

        try {
            DB::beginTransaction();
            $venta = new Venta;
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
            $mano_obra = $request->get('mano_obra');
            $precio_venta = $request->get('precio_venta');
            $cont = 0;

            while ($cont < count($idarticulo)) {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->idventa;
                $detalle->idarticulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->mano_obra = $mano_obra[$cont];
                $detalle->precio_compra = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
                array_push($articulosGuardados, $detalle->idarticulo);
            }
            DB::commit();
            $this->guardarNotificaciones($articulosGuardados);
        } catch (Exception $e) {
            DB::roolback();
            throw $e;
        }
        return Redirect::to('ventas/venta');
    }

    public function guardarNotificaciones($articulosGuardados)
    {
        $admin=new NotificacionAdmin;
        foreach ($articulosGuardados as $articulo) {
            $art = Articulo::find($articulo);
            if ($art->stock < $art->minimo) {
                $admin->create($art->idarticulo);
            }
        }
    }

    public function show($id)
    {
        $venta = DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where('v.idventa', '=', $id)
            ->first();

        $detalles = DB::table('detalle_venta as d')
            ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
            ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_compra', 'd.mano_obra')
            ->where('d.idventa', '=', $id)
            ->get();
        return view("ventas.venta.show", ["venta" => $venta, "detalles" => $detalles]);
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->Estado = 'C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }


}
