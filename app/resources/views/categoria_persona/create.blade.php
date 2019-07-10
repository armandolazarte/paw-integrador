@extends ('layouts.admin')
@section ('contenido')

<section class="page-init">
	<h3>Nueva Categoria de Clientes</h3>
	@include('errors.form')
</section>

<section class="page-form">
	{!!Form::open((array('url' => 'categoria_persona', 'class'=> 'form form-create', 'method'=>'POST', 'autocomplete'=>'off')))!!}
	{{Form::token()}}
	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" placeholder="Nombre...">
	</div>

	<div class="form-control">
		<button class="btn btn-success btn-bg" type="submit">Guardar</button>
		<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
		<a href="{{ URL::previous() }}" class="btn btn-info btn-bg">Volver</a>
	</div>

	{!!Form::close()!!}

</section>

@endsection
