@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Nueva Categoria</h3>
	@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
	@endif
</section>

<section class="page-form">
	{!!Form::open((array('url' => 'almacen/categoria', 'class'=> 'form form-create', 'method'=>'POST', 'autocomplete'=>'off')))!!}
	{{Form::token()}}
	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" placeholder="Nombre...">

		<label for="descripcion">Descripcion</label>
		<input type="text" name="descripcion" placeholder="Descripcion...">

	</div>

	<div class="form-control">
		<button class="btn btn-success btn-bg" type="submit">Guardar</button>
		<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
		<a href="{{url('almacen/categoria')}}" class="btn btn-info btn-bg">Volver</a>
	</div>
	{!!Form::close()!!}
</section>

@endsection
