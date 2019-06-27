@extends ('layouts.admin')
@section ('contenido')
    <section class="section-init">
        <h3>Listado de Usuarios</h3>
        <a href="usuario/create" class="btn btn-success btn-bg">
            Nuevo
        </a>
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
            <th onclick="sortTable(2)">Email</th>
            <th onclick="sortTable(2)">Opciones</th>
            </thead>
            @foreach ($usuarios as $usu)
                <tr>
                    <td>{{$usu->id}}</td>
                    <td>{{$usu->name}}</td>
                    <td>{{$usu->email}}</td>
                    <td>
                        @can('editUsers')
                            <a href="{{URL::action('UsuarioController@edit',$usu->id)}}"
                               class="btn btn-alert btn-md">
                                Editar
                            </a>
                        @endcan
                        @can('destroyUsers')
                            <a href="{{URL::action('UsuarioController@destroy',$usu->id)}}"
                               onclick="destroy( event, '{{$usu->name}}' )"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
        {{$usuarios->render()}}
    </section>
@endsection
