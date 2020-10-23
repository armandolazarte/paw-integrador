@extends ('layouts.admin')
@section ('contenido')
	<section class="page-init">
		<h3>Nuevo Usuario</h3>
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
		{!!Form::open((array('url' => 'seguridad/usuario', 'method'=>'POST', 'autocomplete'=>'off')))!!}
        {{Form::token()}}
        
        <div class="form-group">

            <p>
                <label for="name" class="col-md-4 control-label">Nombre</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
            </p>

            <p>
                <label for="email" class="col-md-4 control-label">E-Mail</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
            </p>

            <p>
                <label for="password" class="col-md-4 control-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password">
            </p>

            <p>
                <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
            </p>


        </div>

	<div class="form-control-3col">
		<button class="btn btn-success btn-bg" type="submit">Guardar</button>
		<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
		<a href="{{ URL::previous() }}" class="btn btn-info btn-bg">Volver</a>
	</div>

	{!!Form::close()!!}
</section>
@endsection
