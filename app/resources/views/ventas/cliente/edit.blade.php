@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Editar Cliente: {{$persona->nombre}}</h3>
	@include('errors.form')
</section>
<section class="page-form">
	{!!Form::model($persona,['method'=>'PATCH', ['ClienteController@edit',$persona->idpersona]])!!}
	{{Form::token()}}
	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" required value="{{$persona->nombre}}" placeholder="Nombre...">

		<label for="direccion">Direccion</label>
		<input type="text" name="direccion" required value="{{$persona->direccion}}" placeholder="Direccion...">

		<label>Documento</label>
		<select name="tipo_documento" class="form-control">
			@if($persona->tipo_documento=='DNI')
				<option value="DNI" selected>DNI</option>
				<option value="CUIT">CUIT</option>
				<option value="PAS">PAS</option>
			@elseif($persona->tipo_documento=='CUIT')
				<option value="DNI">DNI</option>
				<option value="CUIT" selected>CUIT</option>
				<option value="PAS">PAS</option>
			@else
				<option value="DNI">DNI</option>
				<option value="CUIT">CUIT</option>
				<option value="PAS" selected>PAS</option>
			@endif
		</select>

		<label for="num_documento">Numero Documento</label>
		<input type="text" name="num_documento" value="{{$persona->num_documento}}" placeholder="Numero de Documento...">

		<label for="telefono">Telefono</label>
		<input type="text" name="telefono" value="{{$persona->telefono}}" placeholder="Numero de telefono...">

		<label for="email">Email</label>
		<input type="text" name="email" value="{{$persona->email}}" placeholder="Email...">

		<div class="form-control">
			<button class="btn btn-success btn-bg" type="submit">Guardar</button>
			<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
			<a href="{{ URL::previous() }}" class="btn btn-info btn-bg">Volver</a>
		</div>
		{!!Form::close()!!}
	</section>

@endsection
