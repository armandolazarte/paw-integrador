@extends ('layouts.admin')
@section ('contenido')
    <section class="section-init">
        <h3>Listado de Proveedores</h3>
        @can('newProviders')
            <a href="proveedor/create" class="btn btn-success btn-bg">
                Nuevo
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
            <th onclick="sortTable(2)">Tipo de Documento</th>
            <th onclick="sortTable(3)">Numero de Documento</th>
            <th onclick="sortTable(4)">Telefono</th>
            <th onclick="sortTable(5)">Email</th>
            <th onclick="sortTable(6)">Opciones</th>
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
                        <a href="{{URL::action('ProveedorController@show',$per->idpersona)}}"
                           class="btn btn-info btn-md">
                            Ver
                        </a>
                        @can('editProviders')
                        <a href="{{URL::action('ProveedorController@edit',$per->idpersona)}}"
                           class="btn btn-alert btn-md">
                            Editar
                        </a>
                        @endcan
                        @can('destroyProviders')
                            <a href="{URL::action('ProveedorController@destroy',$per->idpersona)}"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
    </div>
    {{$personas->render()}}
    </div>
    </div>
@endsection