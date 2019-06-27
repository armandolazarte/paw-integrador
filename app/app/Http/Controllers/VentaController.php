<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use App\DetalleVenta;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use PDF;

class VentaController extends Controller
{
     public function __construct() {
        $this->middleware('auth');

    }
    public function imprimir($id){
      $venta=DB::table('venta as v')
              ->join('persona as p','v.idcliente','=','p.idpersona')
              ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
              ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
              ->where('v.idventa','=',$id)
              ->first();

      $detalles=DB::table('detalle_venta as d')
               ->join('articulo as a','d.idarticulo','=','a.idarticulo')
               ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.mano_obra')
               ->where('d.idventa','=',$id)
               ->get();
        $tabla='';
        $total=0;
        foreach ($detalles  as $det ) {
          $subtotal=$det->cantidad * $det->precio_venta-$det->descuento;
          $total +=$subtotal;
          $tabla.='<tr>
                    <td>'.$det->articulo.'</td>
                    <td>'.$det->cantidad.'</td>
                    <td>'.$det->precio_venta.'</td>
                    <td>'.$det->mano_obra.'</td>
                    <td>'.$det->descuento.'</td>
                    <td>'.$subtotal.'</td>
                  </tr>';
        };
        $html = '<!DOCTYPE html>

                        <html>

                        <head>

                            <title>REMITO</title>

                            <style type="text/css">

                                table{

                                    width: 100%;

                                    border:1px solid black;

                                }

                                td, th{

                                    border:1px solid black;

                                }
                                bottom {
                                    position: fixed;
                                    bottom: 0;
                                }
                                footer{
                                     position: fixed;
                                     text-align: center;
                                     bottom: 0px;
                                     width: 100%;
                                 }
                            </style>

                        </head>

                        <body>
                        <div>
                            <table style="border: none;">
                                <tr>
                                    <th style="border: none;"><p style="text-align: left">'.date('d/m/Y').'</p></th>
                                    <th style="border: none;"><p style="text-align: right">N° de Remito: '.$venta->num_comprobante.'</p></th>
                                </tr>
                            </table>
                        </div>
                        <div style="text-align: center">
                            <img src="'.GeneralController::getLogo().'" width="1000%" height="1000%">
                        </div>
                        <div style="text-align: left">
                            Cliente: '.$venta->nombre.'
                        </div>
                        <div>
                					<table>
                						<tr>
                							<th>Articulo</th>
                							<th>Cantidad</th>
                							<th>Precio Venta</th>
                							<th>Mano de Obra</th>
                							<th>Descuento</th>
                							<th>Subtotal</th>
                						</tr>
                            '.$tabla.'

                          </table>
                				</div>
                        <div>
                          Total: $'.$total.'
                        </div>

                        <div style="text-align: right">
                          RECIBIDO: ___________________________
                        </div>
                        </body>
                        </html>';
        $html2='<!DOCTYPE html>

                        <html>

                        <head>

                            <title>REMITO</title>

                            <style type="text/css">

                                table{

                                    width: 100%;

                                    border:1px solid black;

                                }

                                td, th{

                                    border:1px solid black;

                                }

                            </style>

                        </head>

                        <body>
                        <div>
                            <table style="border: none;">
                                <tr>
                                    <th style="border: none;"><p style="text-align: left">'.date('d/m/Y').'</p></th>
                                    <th style="border: none;"><p style="text-align: center">COPIA</p></th>
                                    <th style="border: none;"><p style="text-align: right">N° de Remito: '.$venta->num_comprobante.'</p></th>
                                </tr>
                            </table>
                        </div>
                        <div style="text-align: center">
                            <img src="C:\Users\Daniel\Desktop\mg-audio\public\img\backup\mgaudio.jpg" width="1000%" height="1000%">
                        </div>

                        <div>
                					<table>
                						<tr>
                							<th>Articulo</th>
                							<th>Cantidad</th>
                							<th>Precio Venta</th>
                							<th>Mano de Obra</th>
                							<th>Descuento</th>
                							<th>Subtotal</th>
                						</tr>
                            '.$tabla.'

                          </table>

                				</div>
                        <div>
                          Total: $'.$total.'
                        </div>
                        <div style="text-align: right">
                          RECIBIDO: ___________________________
                        </div>


                        </body>

                        </html>';
        PDF::setFooterCallback(function($pdf) {

          // Position at 15 mm from bottom
          $pdf->SetY(-10);
          // Set font
          $pdf->SetFont('helvetica', 'I', 8);
          // Page number
          $texto='Secretaria de Desarrollo Social - Cherubini 450 - General Rodriguez - Buenos Aires - CPA ';
          $texto.='B1748AGJ Tel. (+54) 0237-484-0641 - E-Mail: desarrollosocial@generalrodriguez.gov.ar';
          //$pdf->Cell(0, 10, 'Secretaria de Desarrollo Social - Cherubini 450 - General Rodriguez - Buenos Aires - CPA \n B1748AGJ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
          //$pdf->Cell(0,10,'MG AudioCar - Diario la Nacion 1995, B1746 Francisco Alvarez, Buenos Aires - Teléfono: 011-15-36728941 - Facebook: MG Audio - Instagram: @mgaudio82',0, false, 'C', 0, '', 0, false, 'T', 'M');


          //$pdf->writeHTMLCell(0, 0, '', '', 'MG AudioCar <br>Diario la Nacion 1995, B1746 Francisco Alvarez, Buenos Aires - Teléfono: 011-15-36728941 - <br>Facebook: MG Audio - Instagram: @mgaudio82', 1, 1, false, true, 'C', false);
          //<img src="C:\Users\Daniel\Desktop\mg-audio\public\img\fb.jpg" height="16 px" width="16 px"></img> hay que ver que hacer con esto
            $user_img="";
          asset('img/fb.png').'/'.$user_img;
          $imagen='MG AudioCar <br>Diario la Nacion 1995, B1746 Francisco Alvarez, Buenos Aires - Teléfono: 011-15-36728941 <br>
          Facebook: MG Audio || Instagram: @mgaudio82';
          //seguir desde aca
          $pdf->writeHTMLCell(0, 0, '', '',$imagen, 1, 1, false, true, 'C', false);
        });
        PDF::SetTitle('Remito N° '.$venta->num_comprobante);
        PDF::AddPage();
        PDF::writeHTML($html,true,false,true,false,'');
        PDF::AddPage();
        PDF::writeHTML($html2,true,false,true,false,'');
        PDF::Output('remito_numero_'.$venta->num_comprobante.'.pdf','I');

        //return Redirect::to('personas/beneficiario');//redirecciona al listado de beneficiarios

    }

    public function index(Request $request)
    {
        if ($request)
        {
           $query=trim($request->get('searchText'));
           $query2=trim($request->get('searchText2'));
           $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->select('v.idventa','p.nombre','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where([['p.nombre','LIKE','%'.$query.'%'],['v.fecha_hora','LIKE','%'.$query2.'%']])
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->paginate(7);
          $total=DB::table('venta as v')
          ->join('persona as p','v.idcliente','=','p.idpersona')
          //->join('detalle_venta as dv','v.idventa','=','dv.idventa')
          ->where([['p.nombre','LIKE','%'.$query.'%'],['v.fecha_hora','LIKE','%'.$query2.'%']])
          ->count('v.idventa') //hay que completar el target
          ;
            return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query,"searchText2"=>$query2,"total"=>$total]);

        }
    }
    public function create()
    {
     $personas=DB::table('persona')->where('tipo_persona','=','Cliente')->get();
     $articulos = DB::table('articulo as art')
     ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
     ->join('categoria as c','art.idcategoria','=','c.idcategoria')
     ->select(DB::raw('CONCAT(c.nombre," | ",art.nombre) AS articulo'),'art.idarticulo','art.stock',DB::raw('max(di.precio_venta) as precio_promedio'))
      ->where('art.estado','=','Activo')
      ->where('art.stock','>','0')
      ->groupBy('articulo','art.idarticulo','art.stock')
      ->get();
      $venta=DB::table('venta as v')->select('v.num_comprobante')->orderBy('v.num_comprobante','desc')->first();
      if ($venta==null) {
        $num=1;
      }else {
        $num=$venta->num_comprobante;
        $num=$num+1;
      };
      return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos,"num_comprobante"=>$num]);
    }

     public function store(VentaFormRequest $request){
         try{
            DB::beginTransaction();
            $venta=new Venta;
            $venta->idcliente=$request->get('idcliente');
            $venta->tipo_comprobante=$request->get('tipo_comprobante');
            $venta->serie_comprobante=$request->get('serie_comprobante');
            $venta->num_comprobante=$request->get('num_comprobante');
            $venta->total_venta=$request->get('total_venta');

            $mytime = Carbon::now('America/Argentina/Buenos_Aires');
            $venta->fecha_hora=$mytime->toDateTimeString();
            $venta->impuesto='18';
            $venta->estado='A';
            $venta->save();

            $idarticulo =$request->get('idarticulo');
            $cantidad =$request->get('cantidad');
            $descuento =$request->get('descuento');
            $mano_obra =$request->get('mano_obra');
            $precio_venta =$request->get('precio_venta');
            $cont = 0;

            while ($cont < count($idarticulo)) {

              $detalle = new DetalleVenta();

              $detalle->idventa= $venta->idventa;
              $detalle->idarticulo= $idarticulo[$cont];
              $detalle->cantidad= $cantidad[$cont];
              $detalle->descuento= $descuento[$cont];
              $detalle->mano_obra= $mano_obra[$cont];
              $detalle->precio_venta= $precio_venta[$cont];
              $detalle->save();
              $cont=$cont+1;
            }
            DB::commit();

            }catch(Exception $e){

            DB::roolback();

        }

          return Redirect::to('ventas/venta');

     }

    public function show($id){
        $venta=DB::table('venta as v')
                ->join('persona as p','v.idcliente','=','p.idpersona')
                ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
                ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
                ->where('v.idventa','=',$id)
                ->first();

        $detalles=DB::table('detalle_venta as d')
                 ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                 ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.mano_obra')
                 ->where('d.idventa','=',$id)
                 ->get();
        return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
    }

    public function destroy($id)
    {
     $venta=Venta::findOrFail($id);
        $venta->Estado='C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }


}
