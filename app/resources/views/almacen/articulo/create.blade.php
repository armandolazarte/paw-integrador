@extends ('layouts.admin')
@section ('contenido')
	<section class="page-init">
		<h3>Nuevo Artículo</h3>
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
		{!!Form::open((array('url' => 'almacen/articulo', 'class'=> 'form form-create','method'=>'POST', 'autocomplete'=>'off', 'files'=>'true')))!!}
		{{Form::token()}}

		<div class="form-group">
			
			<p> 
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" placeholder="Nombre...">
			</p>

			<p> 
				<label>Categoria</label>
				<select name="idcategoria" class="form-control selectpicker" data-live-search="true" >
					@foreach ($categorias as $cat)
						<option value="{{$cat->idcategoria}}">{{$cat->nombre}} </option>
					@endforeach
				</select>
			</p>

			<p> 
				<label for="codigo">Codigo</label>
				<input type="text" name="codigo" required value="{{old('codigo')}}" placeholder="Codigo del articulo...">
			</p>

			<p> 
				<label for="minStock">Stock Mínimo</label>
				<input type="number" min="0" name="minStock" required value="{{old('minStock')}}" placeholder="Stock Mínimo...">
			</p>

			<p> 
				<label for="descripcion">Descripcion</label>
				<input type="text" name="descripcion" value="{{old('descripcion')}}" placeholder="Descripcion del articulo...">
			</p>

			<p> 
				<label for="imagen">Imagen</label>
				<input type="file" name="imagen"  >
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
