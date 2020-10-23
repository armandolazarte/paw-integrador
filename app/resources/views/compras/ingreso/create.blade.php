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

		<p>
			<label for="proveedor">Proveedor</label>
			<select name="idproveedor" id="idproveedor" class="form-control selectpicker">
				@foreach($personas as $persona)
				<option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
				@endforeach
			</select>
		</p>

		<p>
			<label>Tipo Comprobante</label>
			<select name="tipo_comprobante" class="form-control">
					<option value="Boleta">Boleta</option>
					<option value="Factura">Factura</option>
					<option value="Ticket">Ticket</option>
			</select>
		</p>

		<p>
			<label for="serie_comprobante">Serie Comprobante</label>
			<input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" placeholder="Serie comprobante...">
		</p>

		<p>
			<label for="num_comprobante">Numero Comprobante</label>
			<input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" placeholder="Numero comprobante...">
		</p>

		<p>
			<label>Articulo</label>
			<span class="autocomplete">
				<input id="inputText" type="text" name="articulo" placeholder="Buscar artículo..." data-endpoint="/api/articulos?inStock=1" data-inputvalue="pidarticulo" />
			</span>
			<input type="hidden" name="pidarticulo" id="pidarticulo">
		</p>

		<p>
			<label for="cantidad">Cantidad</label>
			<input type="number" name="pcantidad" id="pcantidad" placeholder="Cantidad"  value="1">
		</p>

		<p>
			<label for="precio_compra">Precio Compra</label>
			<input type="number" name="pprecio_compra" id="pprecio_compra" placeholder="P. Compra">
		</p>

	</div>

	<button type="button" name="bt_add" id="bt_add" class="btn btn-success btn-bg btn-fullw">Agregar Item <i class="fa fa-plus icon-menu"></i></button>

	<table id="detalles" class="table">
		<thead>
			<th>Opciones</th>
			<th>Articulo</th>
			<th>Cantidad</th>
			<th>Precio Compra</th>
			<th>Subtotal</th>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
			<th colspan="4" style="text-align: right;">TOTAL</th>
			<th><h4 id="total">$/. 0.00</h4></th>
		</tfoot>
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
	<script src="{{asset('js/ingreso.js')}}"></script>
	<script src="{{asset('js/predictive.js')}}"></script>
 @endpush
