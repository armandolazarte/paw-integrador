@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
	<h3>Editar Categoria: {{$categoria->nombre}}</h3>
	@include('errors.form')
</section>
<section class="page-form">
	{!!Form::model($categoria,['method'=>'PATCH', 'class'=> 'form form-edit','route'=>['categoria_persona.update',$categoria->idcategoria]])!!}
	{{Form::token()}}
	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" value="{{$categoria->nombre}}" placeholder="Nombre...">
	</div>

	<div class="form-control">
		<button class="btn btn-success btn-bg" type="submit">Guardar</button>
		<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
		<a href="{{ URL::previous() }}" class="btn btn-info btn-bg">Volver</a>
	</div>
	{!!Form::close()!!}
</section>

@endsection
