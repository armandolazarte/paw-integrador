@extends ('layouts.admin')
@section ('contenido')
    <section class="section-init">
        <h3>Listado de Articulos</h3>
        @can('newArticles')
            <a href="articulo/create" class="btn btn-success btn-bg">
                Agregar
            </a>
        @endcan
    </section>

    <section class="section-content">
    <!-- @include('almacen.articulo.search') -->
        <div class="table-filter">
            <span class="fa fa-search search-icon"></span>
            <input type="text" id="filter" onkeyup="filterTable()" name="searchText" placeholder="Filtrar..."
                   value="{{$searchText}}">
        </div>
        <table class="table-sortable" id="table-info">
            <thead>
            <th onclick="sortTable(0)">Id</th>
            <th onclick="sortTable(1)">Nombre</th>
            <th onclick="sortTable(2)">Codigo</th>
            <th onclick="sortTable(3)">Categoria</th>
            <th onclick="sortTable(4)">Min. Stock</th>
            <th onclick="sortTable(5)">Stock</th>
            <th>Imagen</th>
            <th>Opciones</th>
            </thead>
            @foreach ($articulos as $art)

                <tr
                        @if($art->minStock > $art->stock)
                        class="minstock-alert"
                        @endif>
                    <td>{{$art->idarticulo}}</td>
                    <td>{{$art->nombre}}</td>
                    <td>{{$art->codigo}}</td>
                    <td>{{$art->categoria}}</td>
                    <td>{{$art->minStock}}</td>
                    <td>{{$art->stock}}</td>
                    <td>
                        <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="{{$art->nombre}}" height="100px"
                             width="100px" class="img-thumbnail">
                    </td>

                    <td>
                        {{--                        <a href="{{URL::action('ArticuloController@show',$art->idarticulo)}}"--}}
                        {{--                           class="btn btn-info btn-md">--}}
                        {{--                            Ver--}}
                        {{--                        </a>--}}
                        @can('editArticles')
                            <a href="{{URL::action('ArticuloController@edit',$art->idarticulo)}}"
                               class="btn btn-alert btn-md">
                                Editar
                            </a>
                        @endcan
                        @can('destroyArticles')
                            <a href="{{URL::action('ArticuloController@destroy',$art->idarticulo)}}"
                               onclick="destroy( event, '{{$art->nombre}}' )"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                        @if($art->minStock > $art->stock)
                            <i class="fa fa-exclamation-triangle alert"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        {{$articulos->render()}}
    </section>
    @stack('scripts')
@endsection
