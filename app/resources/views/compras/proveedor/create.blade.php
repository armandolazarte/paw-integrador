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
		<p> 
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" required value="{{old('nombre')}}" placeholder="Nombre...">
		</p> 

		<p> 
			<label for="direccion">Direccion</label>
			<input type="text" name="direccion" required value="{{old('direccion')}}" placeholder="Direccion...">
		</p> 

		<p> 
			<label>Documento</label>
			<select name="tipo_documento" class="form-control">
					<option value="DNI">DNI</option>
					<option value="CUIT">CUIT</option>
					<option value="PAS">PAS</option>
			</select>
		</p> 

		<p> 
			<label for="num_documento">Numero Documento</label>
			<input type="text" name="num_documento" value="{{old('num_documento')}}" placeholder="Numero de Documento...">
		</p> 

		<p> 
			<label for="telefono">Telefono</label>
			<input type="text" name="telefono" value="{{old('telefono')}}" placeholder="Numero de telefono...">
		</p> 

		<p> 
			<label for="email">Email</label>
			<input type="text" name="email" value="{{old('email')}}" placeholder="Email...">
		</p> 

	</div>

	<div class="form-control">
		<button class="btn btn-success btn-bg" type="submit">Guardar</button>
		<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
		<a href="{{ URL::previous() }}" class="btn btn-info btn-bg">Volver</a>
	</div>

		{!!Form::close()!!}

	</section>
@endsection
