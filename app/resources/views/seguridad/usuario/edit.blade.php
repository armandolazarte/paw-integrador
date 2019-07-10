@extends ('layouts.admin')
@section ('contenido')
<section class="page-init">
    <h3>Editar Usuario: {{$usuario->name}}</h3>
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
{!!Form::model($usuario,['method'=>'PATCH', 'route'=>['usuarios.changeRole']])!!}
{{Form::token()}}
<div class="form-group">
    <label for="id" class="col-md-4 control-label" >ID</label>
    <input id="id" type="text" class="form-control"  name="id" value="{{$usuario->id}}" readonly="readonly">
    @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
    <label for="name" class="col-md-4 control-label" >Nombre</label>
    <input id="name" type="text" class="form-control" readonly name="name" value="{{$usuario->name}}">
    @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif

    <label for="role" class="col-md-4 control-label">Seleccione un Rol</label>
    <select name="role" class="form-control" required>
        <option value="fail" disabled selected>Seleccione un Rol...</option>
        @foreach($roles as $r)
            <option value="{{$r->name}}">{{$r->name}}</option>
        @endforeach
    </select>

    </div>

    <div class="form-control">
			<button class="btn btn-success btn-bg" type="submit">Guardar</button>
			<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
			<a href="{{ URL::previous() }}" class="btn btn-info btn-bg">Volver</a>
		</div>

    {!!Form::close()!!}


</section>

@endsection
