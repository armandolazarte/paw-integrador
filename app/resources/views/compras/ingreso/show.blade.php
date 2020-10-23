@extends ('layouts.admin')
@section ('contenido')
<section class="page-content">
	<div class="form-group">
		<label for="proveedor">Proveedor</label>
		<p>{{$ingreso->nombre}}</p>

		<label>Tipo Comprobante</label>
		<p>{{$ingreso->tipo_comprobante}}</p>

		<label for="serie_comprobante">Serie Comprobante</label>
		<p>{{$ingreso->serie_comprobante}}</p>

		<label for="num_comprobante">Numero Comprobante</label>
		<p>{{$ingreso->num_comprobante}}</p>
	</div>

	<table id="detalles" class="table-info">
		<thead>
			<th>Articulo</th>
			<th>Cantidad</th>
			<th>Precio Compra</th>
			<th>Subtotal</th>
		</thead>
		<tfoot>
			<th colspan="3" style="text-align: right;">Total</th>
			<th><h4 id="total">{{$ingreso->total}}</h4></th>
		</tfoot>
		<tbody>
			@foreach($detalles as $det)
				<tr>
					<td>{{$det->articulo}}</td>
					<td>{{$det->cantidad}}</td>
					<td>{{$det->precio_compra}}</td>
					<td>{{$det->cantidad * $det->precio_compra}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

</section>


@endsection
