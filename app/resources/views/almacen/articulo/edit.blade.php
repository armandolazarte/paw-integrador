@extends ('layouts.admin')
@section ('contenido')
    <section class="page-init">
        <h3>Editar Articulo: {{$articulo->nombre}}</h3>
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
        {!!Form::model($articulo,['method'=>'PATCH', 'class'=> 'form form-edit', 'route'=>['articulo.update',$articulo->id], 'files'=>'true'])!!}
        {{Form::token()}}
        <div class="form-group">

            <p> 
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" required value="{{$articulo->nombre}}">
            </p>

            <p> 
            <label>Categoria</label>
            <select name="idcategoria">
                @foreach ($categorias as $cat)
                    @if ($cat->idcategoria==$articulo->idcategoria)
                        <option value="{{$cat->idcategoria}}" selected>{{$cat->nombre}}</option>
                    @else
                        <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                    @endif
                @endforeach
            </select>
            </p>

            <p> 
            <label for="codigo">Codigo</label>
            <input type="text" name="codigo" required value="{{$articulo->codigo}}">
            </p>

            <p> 
            <label for="minStock">Stock Mínimo</label>
            <input type="number" name="minStock" required value="{{$articulo->minStock}}">
            </p>

            <p> 
				<label for="imagen">Precio de venta</label>
				<input type="number" min="0" step="0.1" name="precio_venta" required value="{{$articulo->precio_venta}}" placeholder="Precio">
			</p>

            <p> 
            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" value="{{$articulo->descripcion}}" class="form-control"
                   placeholder="Descripcion del articulo...">
            </p>

            <p> 
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen">
            @if (($articulo->imagen)!="")
                <figure>
                    <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" height="250px" width="250px">
                    <figcaption>Imágen actual</figcaption>
                </figure>
            @endif
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
