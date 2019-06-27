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

		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4 control-label">Nombre</label>
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif

        <label for="email" class="col-md-4 control-label">E-Mail</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
              
        <label for="password" class="col-md-4 control-label">Contraseña</label>
        <input id="password" type="password" class="form-control" name="password">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

      	<label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif

	</div>

	<div class="form-control">
		<input name="_token" value="{{ csrf_token()}}" type="hidden"></input>
		<button class="btn btn-success btn-md" type="submit">Guardar</button>
		<button class="btn btn-danger btn-md" type="reset">Cancelar</button>
	</div>

	{!!Form::close()!!}
</section>
@endsection
