@extends ('layouts.admin')
@section ('contenido')
    <section class="page-init">
        <h3>Listado de Categorias</h3>
        @can('newClientsCategories')
            <a href="categoria_persona/create" class="btn btn-success btn-bg">
                Nueva
            </a>
        @endcan
    </section>
    <section class="section-content">
        <div class="table-filter">
            <span class="fa fa-filter search-icon"></span>
            <input type="text" id="filter" onkeyup="filterTable()" name="searchText" placeholder="Filtrar..."
                   value="{{$searchText}}">
        </div>
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
            <th>Opciones</th>
            </thead>
            @foreach ($categorias as $cat)
                <tr>
                    <td>{{$cat->idcategoria_persona}}</td>
                    <td>{{$cat->nombre}}</td>
                    <td>
                        @can('editClientCategories')
                            <a href="{{URL::action('CategoriaPersonaController@edit',$cat->idcategoria_persona)}}"
                               class="btn btn-alert btn-md">
                                Editar
                            </a>
                        @endcan
                        @can('destroyClientCategories')
                            <a href="{URL::action('CategoriaPersonaController@destroy',$cat->idcategoria_persona)}"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
        {{$categorias->render()}}
    </section>
@endsection
