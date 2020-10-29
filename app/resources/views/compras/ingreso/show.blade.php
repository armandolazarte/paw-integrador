@extends ('layouts.admin')
@section ('contenido')
<section class="page-content">
	<div class="form-group">
		<b>Proveedor</b>
		<p>{{$ingreso->nombre}}</p>

		<b>Tipo Comprobante</b>
		<p>{{$ingreso->tipo_comprobante}}</p>

		<b >Serie Comprobante</b>
		<p>{{$ingreso->serie_comprobante}}</p>

		<b>Numero Comprobante</b>
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
