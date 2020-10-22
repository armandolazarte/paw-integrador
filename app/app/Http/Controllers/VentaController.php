<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\NotificacionAdmin;
use App\Persona;
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

        $respuesta = Venta::getVenta($id);
        $total = 0;
        foreach ($respuesta['detalles'] as $det) {
            $subtotal = $det->cantidad * $det->precio_compra - $det->descuento;
            $total += $subtotal;
        };
        $pdf = new PDF();
        $date = date('d/m/Y');
        $view = \Illuminate\Support\Facades\View::make('pdfs.venta', ['detalles' => $respuesta['detalles'], 'total' => $total, 'fecha' => $date, 'venta' => $respuesta['venta'], 'tipo' => 'ORIGINAL']);
        $html = $view->render();
        $pdf::addPage('P', 'LEGAL');
        $pdf::writeHTML($html, true, false, true, false, '');
        $view = \Illuminate\Support\Facades\View::make('pdfs.venta', ['detalles' => $respuesta['detalles'], 'total' => $total, 'fecha' => $date, 'venta' => $respuesta['venta'], 'tipo' => 'COPIA']);
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
            $respuesta = Venta::getVentas($query, $query2);
            return view('ventas.venta.index', ["ventas" => $respuesta['ventas'], "searchText" => $query, "searchText2" => $query2, "total" => $respuesta['total']]);

        }
    }

    public function create()
    {
        $personas = Persona::getClientes();
        $articulos = Articulo::getArticulosVenta();
        $num = Venta::getNumeroVenta();
        return view("ventas.venta.create", ["personas" => $personas, "articulos" => $articulos, "num_comprobante" => $num]);
    }

    public function store(VentaFormRequest $request)
    {
        Venta::guardarVenta($request);
        return Redirect::to('ventas/venta');
    }

    public function show($id)
    {
        $respuesta = Venta::getVenta($id);
        return view("ventas.venta.show", ["venta" => $respuesta['venta'], "detalles" => $respuesta['detalles']]);
    }

    public function destroy($id)
    {
        Venta::desactivar($id);
        return Redirect::to('ventas/venta');
    }
}
