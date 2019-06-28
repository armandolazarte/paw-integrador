@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Nueva Ingreso</h3>
	@include('errors.form')
</section>

<section class="page-form">
	{!!Form::open((array('url' => 'compras/ingreso', 'method'=>'POST', 'autocomplete'=>'off')))!!}
	{{Form::token()}}

	<div class="form-group">
		<label for="proveedor">Proveedor</label>
		<select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
			@foreach($personas as $persona)
			<option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
			@endforeach
		</select>

		<label>Tipo Comprobante</label>
		<select name="tipo_comprobante" class="form-control">
				<option value="Boleta">Boleta</option>
				<option value="Factura">Factura</option>
				<option value="Ticket">Ticket</option>
		</select>

		<label for="serie_comprobante">Serie Comprobante</label>
		<input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" placeholder="Serie comprobante...">

		<label for="num_comprobante">Numero Comprobante</label>
		<input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" placeholder="Numero comprobante...">

		<label>Articulo</label>
		<input type="text" name="name" id="articulo" list="search_list" placeholder="Buscar...">
		<input type="hidden" name="pidarticulo" id="pidarticulo">
		<datalist id="search_list">
		</datalist>

		<label for="cantidad">Cantidad</label>
		<input type="number" name="pcantidad" id="pcantidad" placeholder="Cantidad">

		<label for="precio_compra">Precio Compra</label>
		<input type="number" name="pprecio_compra" id="pprecio_compra" placeholder="P. Compra">

		<label for="precio_venta">Precio Venta</label>
		<input type="number" name="pprecio_venta" id="pprecio_venta" placeholder="P. Venta">

		<label for="bt_add"></label><br>
		<button type="button" name="bt_add" id="bt_add" class="btn btn-success btn-bg">Agregar</button>
	</div>

	<table id="detalles" class="table">
		<thead>
			<th>Opciones</th>
			<th>Articulo</th>
			<th>Cantidad</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			<th>Subtotal</th>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
			<th>TOTAL</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th><h4 id="total">$/. 0.00</h4></th>
		</tfoot>
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
	<script src="{{asset('js/ingreso.js')}}"></script>
	<script src="{{asset('js/predictive.js')}}"></script>
 @endpush
