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
		<label for="proveedor">Cliente</label>
		<select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
			@foreach($personas as $persona)
			<option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
			@endforeach
		</select>

		<label for="tipo_comprobante" class="control-label">Tipo de Comprobante: </label>
		<input type="text" class="form-control" readonly="" id="tipo_comprobante" name="tipo_comprobante" value="Remito">

		<label for="num_comprobante">Numero de Comprobante</label>
		<input type="text" name="num_comprobante" id="num_comprobante" readonly="" value="{{$num_comprobante}}" class="form-control">

		<label>Articulo</label>
		<select name="pidarticulo" class="form-control selectpicker" id="pidarticulo" data-live-search="true">
				<option value="">Seleccione</option>
			@foreach($articulos as $articulo)
				<option value="{{$articulo->idarticulo}}">{{$articulo->articulo}}</option>
			@endforeach
		</select>

		<label for="cantidad">Cant.</label>
		<input type="number" name="pcantidad" id="pcantidad" placeholder="Cant">

		<label for="cantidad">Stock</label>
		<input type="number" disabled name="pstock" id="pstock" placeholder="Stock">

		<label for="precio_venta">Precio Venta</label>
		<input type="number" disabled name="pprecio_venta" id="pprecio_venta" placeholder="P. Venta">

		<label for="mano_obra">Mano de Obra</label>
		<input type="number" name="pmano_obra" id="pmano_obra" placeholder="Mano de Obra...">

		<label for="descuento">Descuento</label>
		<input type="number" name="pdescuento" id="pdescuento" placeholder="P. Compra">

		</div>
		<div class="form-control">
			<button type="button" id="bt_add" class="btn btn-success btn-bg">Agregar</button>
		</div>

		<table id="detalles" class="table">
			<thead>
				<th>Opciones</th>
				<th>Articulo</th>
				<th>Cantidad</th>
				<th>Precio Venta</th>
				<th>Mano de Obra</th>
				<th>Descuento</th>
				<th>Subtotal</th>
			</thead>
			<tfoot>
				<th>TOTAL</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th><h4 id="total">$/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
			</tfoot>
			<tbody>

			</tbody>
		</table>
		<div class="form-control">
			<input name="_token" value="{{ csrf_token()}}" type="hidden"></input>
			<button class="btn btn-success btn-bg" id="guardar" type="submit">Guardar</button>
			<button class="btn btn-danger btn-bg" type="reset">Cancelar</button>
		</div>

		{!!Form::close()!!}

	</section>

@endsection


@push('scripts')
	<script src="{{asset('js/ventas.js')}}"></script>
 @endpush
