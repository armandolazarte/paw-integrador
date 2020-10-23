<!DOCTYPE html >

<html>

<head>

    <title> REMITO</title>

    <style type="text/css">

        table {

            width: 100%;

            border: 1px solid black;

        }

        td, th {

            border: 1px solid black;

        }

        bottom {
            position: fixed;
            bottom: 0;
        }

        footer {
            position: fixed;
            text-align: center;
            bottom: 0px;
            width: 100%;
        }
        page{
            height: 400px;
        }
    </style>

</head>

<body>
<div class="page">
    <div>
        <table style="border: none;">
            <tr>
                <th style="border: none;"><p style="text-align: left"> {{$fecha}} </p></th>
                <th style="border: none;"><p style="text-align: center">{{$tipo}}</p></th>
                <th style="border: none;"><p style="text-align: right"> N° de Remito: {{$venta->num_comprobante}}</p>
                </th>
            </tr>
        </table>
    </div>
    <div style="text-align: center">
        <img src="" width="1000%" height="1000%">
    </div>
    <div style="text-align: left">
        Cliente: {{$venta->nombre}}
    </div>
    <div>
        <table>
            <tr>
                <th> Articulo</th>
                <th> Cantidad</th>
                <th> Precio Venta</th>
                <th> Descuento</th>
                <th> Subtotal</th>
            </tr>
            @foreach($detalles as $det)
                <tr>
                    <td>{{$det->articulo}}</td>
                    <td>{{$det->cantidad}}</td>
                    <td>{{$det->precio_venta}}</td>
                    <td>{{$det->descuento}}</td>
                    <td>{{$det->cantidad * $det->precio_venta-$det->descuento}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div>
        
    </div>

    <div style="text-align: right">
        RECIBIDO: ___________________________
    </div>
</div>

</body>
</html>