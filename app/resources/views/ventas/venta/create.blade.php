@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Nueva Venta</h3>
	@include('errors.form')
</section>

<section class="page-form">
	{!!Form::open((array('url' => 'ventas/venta', 'method'=>'POST', 'autocomplete'=>'off')))!!}
	{{Form::token()}}
	<div class="form-group">

	<p>
		<label for="proveedor">Cliente</label>
		<select name="idcliente" id="idcliente" class="form-control">
			@foreach($personas as $persona)
			<option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
			@endforeach
		</select>
	</p>

	<p>
		<label for="tipo_comprobante" class="control-label">Tipo de Comprobante: </label>
		<select class="form-control" id="tipo_comprobante" name="tipo_comprobante">
				<option value="Remito">Remito</option>
				<option value="final">Factura B a Consumidor Final</option>
				<option value="monotributo">Factura B a Responsable Monotributo</option>
		</select>
	</p>

	<p>
		<label for="num_comprobante">Numero de Comprobante</label>
		<input type="text" name="num_comprobante" id="num_comprobante" readonly="" value="{{$num_comprobante}}" class="form-control">
	</p>

	<p>
			<label>Articulo</label>
			<span class="autocomplete">
				<input id="inputText" type="text" name="articulo" placeholder="Buscar artículo..." data-endpoint="/almacen/articulo" data-inputvalue="pidarticulo" />
			</span>
			<input type="hidden" name="pidarticulo" id="pidarticulo">
	</p>

	<p>
		<label for="cantidad">Stock</label>
		<input type="number" disabled name="pstock" id="pstock" placeholder="Stock" readOnly>
	</p>

	<p>
		<label for="precio_venta">Precio Venta</label>
		<input type="number" disabled name="pprecio_venta" id="pprecio_venta" placeholder="P. Venta" readOnly>
	</p>

	<p>
		<label for="cantidad">Cant.</label>
		<input type="number" name="pcantidad" id="pcantidad" placeholder="Cant"  value="1">
	</p>

	<p>
		<label for="descuento">Descuento ($)</label>
		<input type="number" name="pdescuento" id="pdescuento" placeholder="Descuento..."  value="0">
	</p>

	<button type="button" name="bt_add" id="bt_add" class="btn btn-success btn-bg btn-fullw">Agregar Item <i class="fa fa-plus icon-menu"></i></button>

	</div>

		<table id="detalles" class="table">
			<thead>
				<th>Opciones</th>
				<th>Articulo</th>
				<th>Cantidad</th>
				<th>Precio Venta</th>
				<th>Descuento</th>
				<th>Subtotal</th>
			</thead>
			<tfoot>
				<th>TOTAL</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th><h4 id="total">$/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
			</tfoot>
			<tbody>

			</tbody>
		</table>
		<div class="form-control-2col">
			<input name="_token" value="{{ csrf_token()}}" type="hidden"></input>
			<button class="btn btn-success btn-bg" id="guardar" type="submit">Guardar</button>
			<button class="btn btn-danger btn-bg" type="reset">Cancelar</button>
		</div>

		{!!Form::close()!!}

	</section>

@endsection


@push('scripts')
	<script src="{{asset('js/ventas.js')}}"></script>
	<script src="{{asset('js/predictive.js')}}"></script>
 @endpush
 