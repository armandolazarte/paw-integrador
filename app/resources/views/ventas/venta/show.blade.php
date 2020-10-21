@extends ('layouts.admin')
@section ('contenido')
<section class="page-content">
	<div class="form-group">

		<label for="proveedor">Cliente</label>
		<p>{{$venta->nombre}}</p>

		<label>Tipo Comprobante</label>
		<p>{{$venta->tipo_comprobante}}</p>

		<label for="serie_comprobante">Serie Comprobante</label>
		<p>{{$venta->serie_comprobante}}</p>

		<label for="num_comprobante">Numero Comprobante</label>
		<p>{{$venta->num_comprobante}}</p>

	</div>

	<table id="detalles" class="table">
		<thead>
			<th>Articulo</th>
			<th>Cantidad</th>
			<th>Precio Venta</th>
			<th>Descuento</th>
			<th>Subtotal</th>
		</thead>
		<tfoot>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th><h4 id="total">{{$venta->total_venta}}</h4></th>
		</tfoot>
		<tbody>
			@foreach($detalles as $det)
				<tr>
					<td>{{$det->articulo}}</td>
					<td>{{$det->cantidad}}</td>
					<td>{{$det->precio_venta}}</td>
					<td>{{$det->descuento}}</td>
					<td>{{$det->cantidad * $det->precio_venta-$det->descuento}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<a href="{{URL::action('VentaController@imprimir',$venta->idventa)}}"><button class="btn btn-info btn-bg">Imprimir</button></a>

</section>
@endsection
