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
        {!!Form::model($articulo,['method'=>'PATCH', 'class'=> 'form form-edit', 'route'=>['articulo.update',$articulo->idarticulo], 'files'=>'true'])!!}
        {{Form::token()}}
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" required value="{{$articulo->nombre}}">

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

            <label for="codigo">Codigo</label>
            <input type="text" name="codigo" required value="{{$articulo->codigo}}">

            <label for="stock">Stock</label>
            <input type="number" name="stock" required value="{{$articulo->stock}}">

            <label for="minStock">Stock Mínimo</label>
            <input type="number" name="minStock" required value="{{$articulo->minStock}}">

            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" value="{{$articulo->descripcion}}" class="form-control"
                   placeholder="Descripcion del articulo...">

            <label for="imagen">Imagen</label>
            <input type="file" name="imagen">
            @if (($articulo->imagen)!="")
                <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" height="300px" width="300px">
            @endif

        </div>

        <div class="form-control">
    			<button class="btn btn-success btn-bg" type="submit">Guardar</button>
    			<button class="btn btn-danger btn-bg" type="reset">Limpiar</button>
    			<a href="{{ URL::previous() }}" class="btn btn-info btn-bg">Volver</a>
    		</div>

        {!!Form::close()!!}


    </section>


@endsection
