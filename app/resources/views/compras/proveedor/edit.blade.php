@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Editar Proveedor: {{$persona->nombre}}</h3>
	@include('errors.form')
</section>
<section class="page-form">
	{!!Form::model($persona,['method'=>'PATCH', 'route'=>['proveedor.update',$persona->idpersona]])!!}
	{{Form::token()}}
	<div class="form-group">

		<p> 
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" required value="{{$persona->nombre}}" placeholder="Nombre...">
		</p> 

		<p> 
			<label for="direccion">Direccion</label>
			<input type="text" name="direccion" required value="{{$persona->direccion}}" placeholder="Direccion...">
		</p> 

		<p> 
			<label>Documento</label>
			<select name="tipo_documento" class="form-control">
					<option value="DNI" {{ ($persona->tipo_documento=='DNI')? 'selected' : '' }}>DNI</option>
					<option value="CUIT" {{ ($persona->tipo_documento=='CUIT')? 'selected' : '' }}>CUIT</option>
					<option value="PAS" {{ ($persona->tipo_documento=='PAS')? 'selected' : '' }}>PAS</option>
			</select>
		</p> 

		<p> 
			<label for="num_documento">Numero Documento</label>
			<input type="text" name="num_documento" value="{{$persona->num_documento}}" placeholder="Numero de Documento...">
		</p> 

		<p> 
			<label for="telefono">Telefono</label>
			<input type="text" name="telefono" value="{{$persona->telefono}}" placeholder="Numero de telefono...">
		</p> 

		<p> 
			<label for="email">Email</label>
			<input type="text" name="email" value="{{$persona->email}}" placeholder="Email...">
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
