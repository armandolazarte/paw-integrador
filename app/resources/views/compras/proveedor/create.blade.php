@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Nueva Proveedor</h3>
	@include('errors.form')
</section>

<section class="page-form">
	{!!Form::open((array('url' => 'compras/proveedor', 'method'=>'POST', 'autocomplete'=>'off')))!!}
	{{Form::token()}}
	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" required value="{{old('nombre')}}" placeholder="Nombre...">

		<label for="direccion">Direccion</label>
		<input type="text" name="direccion" required value="{{old('direccion')}}" placeholder="Direccion...">

		<label>Documento</label>
		<select name="tipo_documento" class="form-control">
				<option value="DNI">DNI</option>
				<option value="CUIT">CUIT</option>
				<option value="PAS">PAS</option>
		</select>

		<label for="num_documento">Numero Documento</label>
		<input type="text" name="num_documento" value="{{old('num_documento')}}" placeholder="Numero de Documento...">

		<label for="telefono">Telefono</label>
		<input type="text" name="telefono" value="{{old('telefono')}}" placeholder="Numero de telefono...">

		<label for="email">Email</label>
		<input type="text" name="email" value="{{old('email')}}" placeholder="Email...">

		<div class="form-control">
			<button class="btn btn-success btn-md" type="submit">Guardar</button>
			<button class="btn btn-danger btn-md" type="reset">Cancelar</button>
		</div>

		{!!Form::close()!!}

	</section>
@endsection