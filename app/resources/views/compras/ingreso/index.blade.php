@extends ('layouts.admin')
@section ('contenido')
    <section class="section-init">
        <h3>Listado de Ingresos</h3>
        @can('newIncomes')
            <a href="ingreso/create" class="btn btn-success btn-bg">
                Agregar ingreso
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
            <th onclick="sortTable(0)">Fecha</th>
            <th onclick="sortTable(1)">Proveedor</th>
            <th onclick="sortTable(2)">Tipo Comprobante</th>
            <th onclick="sortTable(3)">Impuesto</th>
            <th onclick="sortTable(4)">Total</th>
            <th onclick="sortTable(5)">Estado</th>
            <th onclick="sortTable(6)">Opciones</th>
            </thead>
            @foreach ($ingresos as $ing)
                <tr>
                    <td>{{$ing->fecha_hora}}</td>
                    <td>{{$ing->nombre}}</td>
                    <td>{{$ing->tipo_comprobante.': '.$ing->serie_comprobante.'-'.$ing->num_comprobante}}</td>
                    <td>{{$ing->impuesto}}</td>
                    <td>{{$ing->total}}</td>
                    <td>{{$ing->estado}}</td>
                    <td>
                        <a href="{{URL::action('IngresoController@show',$ing->idingreso)}}" class="btn btn-info btn-md">
                            Detalles
                        </a>
                        @can('destroyIncomes')
                            <a href="{URL::action('IngresoController@destroy',$ing->idingreso)}"
                               class="btn btn-danger btn-md">
                                Eliminar
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
        {{$ingresos->render()}}
    </section>
@endsection
