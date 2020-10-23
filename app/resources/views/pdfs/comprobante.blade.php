<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Vouchers</title>
<style type="text/css">
    @page  {
      margin: 0.5cm;
      size: letter; /*or width x height 150mm 50mm*/
    }
    .page-break {
        page-break-after: always;
    }

    body{
        font-size: 12px;
        font-family: "Arial, Helvetica, sans-serif";
        
    }
    table{
        border-collapse: collapse;
        border: solid 1px;
    }
    td, th{
        font-size: 12px;
    }

    table.owner, table.client {
        margin: 4px 0;
    }

    table p {

      margin-block-end: 0;
      margin-block-start: 0;

    }

    span.original {
      font-size: 18px;
      font-weight: bold;
    }

    td.type {
      border: 1px solid;
      text-align: center;
      padding: 0px 0px;
      border-spacing: 0px;
      
    }

    span.type-letter  {
      font-size: 35px;
      font-weight: bold;
      margin-block-end: 0;
      margin-block-start: 0;
    }
    
    span.type-code {
      font-size: 10px;
      text-align: center;
      font-weight: bold;
      margin-block-end: 0;
      margin-block-start: 0;

    }

    .detalle thead {
        background: #80808091;
        border: 1px solid black;
      }

    .detalle tfoot {
        border: solid 1px black;
        text-align: right;
    }

    .detalle tr {
        font-weight: bold;
    }

    .detalle tfoot tr {
        border-right: solid 0px #FFF;
        border-bottom: solid 0px #FFF;
    }

    .footer {
      border: solid 0px #FFF;
            position: fixed; 
            bottom: 130;
        }
</style>
</head>
<body>
    <table border="" cellspacing="1" cellpadding="4" width="100%" class="owner">
      
        <tbody>
        <tr>
        <td colspan="1" style="border-bottom: 1px solid black;">
                  
                  </td>
              <td colspan="10" style="border-bottom: 1px solid black; text-align:center;">
                
                <span class="original">ORIGINAL</span>
                  
              </td>
              <td colspan="1" style="border-bottom: 1px solid black;">
                  
              </td>
            
        </tr>
            <tr>
                <td colspan="5" style="width:43%;">
                    <p style="text-align: center;font-weight: bold;font-size: 24px;">EMPRESA</p>
                </td>
                <td class="type" colspan="2">
                    <span class="type-letter">{{ $type_voucher}}</span>
                    @if ($type_voucher !== 'X')
                    <br>
                    <span class="type-code">{{ $voucher['code_voucher'] }}</span>
                    @endif
                </td>
                <td colspan="5" >
                  <span style="font-weight: bold;font-size: 24px; margin-left: 30px">{{($type_voucher == 'X' )? 'RECIBO' : 'FACTURA'}}</span><br><br>
                  @if ($type_voucher !== 'X')
                  <span style="font-weight: bold; margin-left: 30px">Punto de Venta: 0000{{ $voucher['pto_vta'] }}    Comp. Nro: {{ $voucher['nro_invoice'] }}</span> <br>
                  @endif
                  <span style="font-weight: bold; margin-left: 30px">Fecha de Emisión: {{ $voucher['date'] }}</span> <br>
                </td>
            </tr>
            <tr>
              <td colspan="5" >
                <span style="font-weight: bold;">Razón social:</span> Empresa de Fantasía <br><br>
                <span style="font-weight: bold;">Domicilio Comercial:</span> Dirección 1 - Lujan, Bs As<br><br>
                <span style="font-weight: bold;">Condición frente al IVA: Responsable inscripto</span>  <br>
              </td>
              <td colspan="1" style="border-right: 1px solid black;"></td>
              <td colspan="1"></td>
              <td colspan="5" style="border-right: 1px solid black;" >
                <span style="font-weight: bold; margin-left: 30px">CUIT:</span> XXXXXXXXXXX <br>
                <span style="font-weight: bold; margin-left: 30px">Ingresos Brutos:</span> XXXXXXXXXXX <br>
                <span style="font-weight: bold; margin-left: 30px">Fecha de Inicio de Actividades:</span> 29/10/2020 <br>
              </td>
            </tr>
        </tbody>
    </table>

    <table border="" cellspacing="1" cellpadding="4" width="100%" class="client">
        <tbody>
            <tr>
                <td width="40%" style=" border-right: solid 1px #FFF;">
                    <span style="font-weight: bold;">{{ $cliente['tipo_documento'] == 'CUIT' ? 'CUIT' : 'DNI' }}:</span> {{ $cliente['num_documento'] }}<br><br>
                    <span style="font-weight: bold;">Condición frente al IVA:</span> Cosumidor Final<br><br>
                    <span style="font-weight: bold;">Condición de venta:</span><br>
                </td>
                <td width="60%" style=" border-right: solid 1px #FFF;">
                  <span style="font-weight: bold;">Apellido y Nombre / Razón Social:</span> {{ $cliente['nombre'] }}<br><br>
                  <span style="font-weight: bold;">Domicilio:</span> {{ $cliente['direccion'] }}<br><br>
                </td>
            </tr>
        </tbody>
    </table>

    <table border="" cellspacing="1" cellpadding="4" width="100%" class="detalle">
      <thead>
        <tr>
          <th> Articulo</th>
          <th> Cantidad</th>
          <th> Precio Venta</th>
          <th> Descuento</th>
          <th> Subtotal</th>
        </tr>
      </thead>
      <tbody>
      @foreach($detalles as $det)
                <tr>
                    <td align="center">{{$det->articulo}}</td>
                    <td align="center">{{$det->cantidad}}</td>
                    <td align="center">{{$det->precio_venta}}</td>
                    <td align="center">{{$det->descuento}}</td>
                    <td align="center">{{$det->cantidad * $det->precio_venta-$det->descuento}}</td>
                </tr>
            @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">Subtotal:</td>
          <td>$ {{ $total }}</td>
        </tr>
        <tr>
          <td colspan="4">Importe Otros Tributos:</td>
          <td>$ 0,00</td>
        </tr>
        <tr>
          <td colspan="4">Importe Total:</td>
          <td>$ {{ $total }}</td>
        </tr>
      </tfoot>
    </table>
    @if ($type_voucher !== 'X')
    <table cellspacing="1" cellpadding="4" width="100%" class="footer">
        <tbody>
          <tr>
              <td colspan="6" style="vertical-align: middle;">
                  <div style="margin-left: 8px;">  
                    <img id="logo" src="imagenes/afip-logo.png" alt="" width="100px" /> <span style="text-align: center;font-weight: bold;font-size: 18px;">  Comprobante Autorizado</span><br>
                    <span style="font-size: 8px;">Esta Administración Federal no se responsabiliza por los datos ingresados en el detalle de la operación</span> <br>
                    </div>
              </td>
              <td colspan="4">
              <span style="font-size: 13px; font-weight: bold;">CAE N°: {{$voucher['cae']}}</span> <br>
              <span style="font-size: 13px; font-weight: bold;">Fecha de Vto. de CAE: {{$voucher['cae_date']}}</span>
              </td>
          </tr>
        </tbody>
    </table>
    @endif
</body>
</html>