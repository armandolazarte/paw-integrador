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
        $info = [];
        $info['date'] = Carbon::parse($respuesta['venta']->fecha_hora)->format('d/m/Y');
        foreach ($respuesta['detalles'] as $det) {
            $subtotal = $det->cantidad * $det->precio_venta - $det->descuento;
            $total += $subtotal;
        };

        //Cliente
        $cliente = Persona::find($respuesta['venta']->idcliente);

        if ($respuesta['venta']->tipo_comprobante == 'afip') {
            $afip = json_decode($respuesta['venta']->info_afip);
            $info['code_voucher'] = '006';
            $info['date'] = Carbon::createFromFormat('YmdHis', $afip->FeCabResp->FchProceso)->format('d/m/Y');
            $info['pto_vta'] = \Config::get('app.afip_pto_venta');
            $info['nro_invoice'] = str_pad($afip->nro_afip, 8, "0", STR_PAD_LEFT);
            $info['cae'] = $afip->FeDetResp->FECAEDetResponse->CAE;
            $info['cae_date'] = Carbon::createFromFormat('Ymd', $afip->FeDetResp->FECAEDetResponse->CAEFchVto)->format('d/m/Y');

            //El nro del barcode se genera: CUIT + COD FC + PTO VENTA + CAE + VTO CAE + NRO VERIFICADOR
            $nro_barcode = \Config::get('app.afip_cuit') . $info['code_voucher'] . 
                            \Config::get('app.afip_pto_venta') . $afip->FeDetResp->FECAEDetResponse->CAE .
                            Carbon::createFromFormat('Ymd', $afip->FeDetResp->FECAEDetResponse->CAEFchVto)->format('Ymd').
                            substr(\Config::get('app.afip_cuit'), -1);
            $verification_code = $this->getDigitoVerificador($nro_barcode);
            $nro_barcode .= $verification_code;

            $info['nro_barcode'] = $nro_barcode;

        }
        
        $date = date('d/m/Y');
        $data = array (
            'type_voucher' => ($respuesta['venta']->tipo_comprobante == 'afip') ? 'B' : 'X',
            'voucher' => $info,
            'cliente' => $cliente,
            'detalles' => $respuesta['detalles'], 
            'total' => $total, 
            'fecha' => $date, 
            'venta' => $respuesta['venta'], 
            'tipo' => 'ORIGINAL'
        );

        $pdf = PDF::loadView('pdfs.comprobante', $data);
        //return $pdf->download('afip_'.$date.'.pdf');
        //return view('templates.facturas.afip', $data);
        return $pdf->stream('comprobante_'.$date.'.pdf'); 

    }

    public function getDigitoVerificador(string $Numero)
    {

        $j=strlen($Numero);
        $par=0;$impar=0;
        for ($i=0; $i < $j ; $i++) { 
            if ($i%2==0){
                $par=$par+$Numero[$i];
            }else{
                $impar=$impar+$Numero[$i];
        
            }
            
        }
        
        $par=$par*3;
        $suma=$par+$impar;
        for ($i=0; $i < 9; $i++) {
            if ( fmod(($suma +$i),10) == 0) {
                $verificador=$i;
            }
        }
        
        $digito = 10 - ($suma - (intval($suma / 10) * 10));
        if ($digito == 10){
            $digito = 0;
        }

        return (string) $digito;
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
        $afip = ($request->get('tipo_comprobante') == 'afip') ? true : false;
        $venta = Venta::guardarVenta($request);

        //Facturo o no por AFIP
        if ($afip) {
            $this->crearComprobanteAfip($venta);
        }
        

        return Redirect::to('ventas/venta');
    }

    public function crearComprobanteAfip($venta) {

        $cliente = Persona::find($venta->idcliente);
        $doc_type = 96;
        $dni = $cliente->num_documento;

        $data = array (
                'CbteTipo'  => \Config::get('app.afip_fc_b'),
                'DocTipo' => $doc_type,
                'DocNro' => $dni,
                'ImpTotal' => $venta->total_venta,
                'ImpNeto' => $venta->total_venta,
                'ImpIVA' => 0
        );


        $response = $this->conectarAfip($data);
        $response->info = $venta;

        

        $venta->info_afip = json_encode($response);
        $venta->save();

        return true;
    }

    public function conectarAfip($info) {

        include 'AfipFolder/Afip.php'; 
        $afip = new \Afip(array(
                            'CUIT' => \Config::get('app.afip_cuit'),
                            'production'  => \Config::get('app.afip_enviroment')
                        ));
        $nro_voucher = $afip->ElectronicBilling->GetLastVoucher(\Config::get('app.afip_pto_venta'),$info['CbteTipo']) + 1;

        $data = array(
            'CantReg' 		=> 1, // Cantidad de comprobantes a registrar
            'PtoVta' 		=> \Config::get('app.afip_pto_venta'), // Punto de venta
            'CbteTipo' 		=> $info['CbteTipo'], // Tipo de comprobante (ver tipos disponibles)  1/ 6
            'Concepto' 		=> 1, // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo' 		=> $info['DocTipo'], // Tipo de documento del comprador (ver tipos disponibles) 80 / 88
            'DocNro' 		=> $info['DocNro'], // Numero de documento del comprador
            'CbteDesde' 	=> $nro_voucher, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
            'CbteHasta' 	=> $nro_voucher, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
            'CbteFch' 		=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal' 		=> $info['ImpTotal'], // Importe total del comprobante
            'ImpTotConc' 	=> 0, // Importe neto no gravado
            'ImpNeto' 		=> $info['ImpNeto'], // Importe neto gravado
            'ImpOpEx' 		=> 0, // Importe exento de IVA
            'ImpIVA' 		=> $info['ImpIVA'], //Importe total de IVA
            'Iva' 			=> array( // (Opcional) Alícuotas asociadas al comprobante
                array(
                    'Id' 		=> ($info['CbteTipo'] == 1) ? 5 : 3, // 5 Id del tipo de IVA (ver tipos disponibles) 
                    'BaseImp' 	=> ($info['CbteTipo'] == 1) ? 100 : $info['ImpNeto'], // Base imponible
                    'Importe' 	=> ($info['CbteTipo'] == 1) ? 21 : 0, // Importe 
                )
            ), 
            'ImpTrib' 		=> 0, //Importe total de tributos
            'MonId' 		=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
            'MonCotiz' 		=> 1, // Cotización de la moneda usada (1 para pesos argentinos)  
        ); 


        
        $res = $afip->ElectronicBilling->CreateVoucher($data, TRUE);
        $res->nro_afip = $nro_voucher;

        return $res;

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
