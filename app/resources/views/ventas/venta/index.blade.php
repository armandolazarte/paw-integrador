@extends ('layouts.admin')
@section ('contenido')
    <section class="section-init">
        <h3>Listado de Ventas</h3>
        <a href="venta/create" class="btn btn-success btn-bg">
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
              Fecha
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(1)">
              Cliente
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(2)">
              Tipo Comprobante
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(3)">
              Total
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(4)">
              Estado
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th>Opciones</th>
            </thead>
            @foreach ($ventas as $ven)
                <tr>
                    <td>{{$ven->fecha_hora}}</td>
                    <td>{{$ven->nombre}}</td>
                    <td>{{ $ven->tipo_comprobante.': '.$ven->serie_comprobante.''.$ven->num_comprobante}}</td>


                    <td>{{$ven->total_venta}}</td>
                    <td>{{$ven->estado}}</td>

                    <td>
                        <a href="{{URL::action('VentaController@show',$ven->idventa)}}" class="btn btn-info btn-md">
                            Detalles
                        </a>
                        <a href="{{URL::action('VentaController@edit',$ven->idventa)}}" class="btn btn-alert btn-md">
                            Editar
                        </a>
                        @can('destroyProveedores')
                            <a href="{URL::action('VentaController@destroy',$ven->idventa)}"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
        {{$ventas->render()}}
    </section>
@endsection
