@extends ('layouts.admin')
@section ('contenido')
    <section class="page-init">
        <h3>Listado de Clientes</h3>
        <a href="cliente/create" class="btn btn-success btn-bg">
            Nuevo
        </a>
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
            <th onclick="sortTable(2)">
              Tipo de Documento
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(3)">
              Numero de Documento
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(4)">
              Telefono
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(5)">
              Email
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th>Opciones</th>
            </thead>
            @foreach ($personas as $per)
                <tr>
                    <td>{{$per->idpersona}}</td>
                    <td>{{$per->nombre}}</td>
                    <td>{{$per->tipo_documento}}</td>
                    <td>{{$per->num_documento}}</td>
                    <td>{{$per->telefono}}</td>
                    <td>{{$per->email}}</td>
                    <td>
                        <a href="{{URL::action('ClienteController@show',$per->idpersona)}}" class="btn btn-info btn-md">
                            Ver
                        </a>
                        <a href="{{URL::action('ClienteController@edit',$per->idpersona)}}"
                           class="btn btn-alert btn-md">
                            Editar
                        </a>
                        @can('destroyProveedores')
                            <a href="{URL::action('ClienteController@destroy',$per->idpersona)}"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
        {{$personas->render()}}
    </section>
@endsection
