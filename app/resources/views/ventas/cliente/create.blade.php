@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Nueva Cliente</h3>
	@include('errors.form')
</section>

<section class="page-form">
	{!!Form::open((array('url' => 'ventas/cliente', 'method'=>'POST', 'autocomplete'=>'off')))!!}
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

		<label for="proveedor">Categoria del Cliente</label>
		<select name="idcategoria_persona" id="idcategoria_persona" class="form-control selectpicker" data-live-search="true">
			@foreach($categorias as $categoria)
				<option value="{{$categoria->idcategoria_persona}}">{{$categoria->nombre}}</option>
			@endforeach
		</select>

		<div class="form-control">
			<input name="_token" value="{{ csrf_token()}}" type="hidden"></input>
			<button class="btn btn-success btn-bg" type="submit">Guardar</button>
			<button class="btn btn-danger btn-bg" type="reset">Cancelar</button>
		</div>

		{!!Form::close()!!}

	</section>

	@endsection
