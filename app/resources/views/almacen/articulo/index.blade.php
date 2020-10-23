@extends ('layouts.admin')
@section ('contenido')
    <section class="page-init">
        <h3>Listado de Articulos</h3>
        @can('newArticles')
            <a href="articulo/create" class="btn btn-success btn-bg">
                Agregar
            </a>
        @endcan
    </section>

    <section class="section-content">
        @include('almacen.articulo.search')
        <table class="table-sortable" id="table-info">
            <thead>
            <th onclick="sortTable(0)">
              Id
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(1)">
              Nombre
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(2)">
              Codigo
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(3)">
              Categoria
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(4)">
              Min. Stock
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(5)">
              Stock
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(6)">
              $
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th>Imagen</th>
            <th>Opciones</th>
            </thead>
            <tbody id="tablebody">
            @foreach ($articulos as $art)

                <tr>
                    <td>{{$art->id}}</td>
                    <td>{{$art->nombre}}</td>
                    <td>{{$art->codigo}}</td>
                    <td>{{$art->categoria}}</td>
                    <td>{{$art->minStock}}</td>
                    <td>{{$art->stock}}</td>
                    <td>{{$art->precio_venta}}</td>
                    <td>
                        <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" class="thumbs" alt="{{$art->nombre}}" class="img-thumbnail">
                    </td>

                    <td>
                        <a href="{{URL::action('ArticuloController@show',$art->id)}}"
                           class="btn btn-info btn-md">
                            Ver
                        </a>
                        @can('editArticles')
                            <a href="{{URL::action('ArticuloController@edit',$art->id)}}"
                               class="btn btn-alert btn-md">
                                Editar
                            </a>
                        @endcan
                        @can('destroyArticles')
                            <a href="{{URL::action('ArticuloController@destroy',$art->id)}}"
                               onclick="destroy( event, '{{$art->nombre}}' )"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$articulos->render()}}
    </section>
    
    @push('scripts')
    	<script src="{{asset('js/search.js')}}"></script>
     @endpush
@endsection
