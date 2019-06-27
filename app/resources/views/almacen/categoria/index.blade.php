@extends ('layouts.admin')
@section ('contenido')

    <section class="section-init">
        <h3>Listado de Categorias</h3>
        @can('newCategories')
            <a href="categoria/create" class="btn btn-success btn-bg">
                Nueva
            </a>
        @endcan
    </section>



    <section class="section-content">
        <div class="table-filter">
            <span class="fa fa-search search-icon"></span>
            <input type="text" id="filter" onkeyup="filterTable()" name="searchText" placeholder="Filtrar..."
                   value="{{$searchText}}">
        </div>
        <table class="table-sortable" id="table-info">
            <thead>
            <th onclick="sortTable(0)">Id</th>
            <th onclick="sortTable(1)">Nombre</th>
            <th onclick="sortTable(2)">Descripción</th>
            <th onclick="sortTable(3)">Opciones</th>
            </thead>
            @foreach ($categorias as $cat)
                <tr>
                    <td>{{$cat->idcategoria}}</td>
                    <td>{{$cat->nombre}}</td>
                    <td>{{$cat->descripcion}}</td>
                    <td>
                        @can('editCategories')
                        <a href="{{URL::action('CategoriaController@edit',$cat->idcategoria)}}"
                           class="btn btn-alert btn-md">
                            Editar
                        </a>
                        @endcan
                        @can('destroyCategories')
                            <a href="{URL::action('CategoriaController@destroy',$cat->idcategoria)}"
                               onclick="destroy( event, '{{$cat->nombre}}' )"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
@endsection
