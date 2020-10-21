@extends ('layouts.admin')
@section ('contenido')
	<section class="page-init">
		<h3>Editar Categoria: {{$categoria->nombre}}</h3>
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
		{!!Form::model($categoria,['method'=>'PATCH', 'class'=> 'form form-edit', 'route'=>['categoria.update',$categoria->idcategoria]])!!}
		{{Form::token()}}
			<div class="form-group">

			<p> 
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" class="form-control" value="{{$categoria->nombre}}" placeholder="Nombre...">
			</p>

			<p>
				<label for="descripcion">Descripcion</label>
				<input type="text" name="descripcion" class="form-control" value="{{$categoria->descripcion}}" placeholder="Descripcion...">
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
