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
		<button class="btn btn-success btn-md" type="submit">Guardar</button>
		<button class="btn btn-danger btn-md" type="reset">Cancelar</button>
	</div>

	{!!Form::close()!!}

</section>

@endsection
