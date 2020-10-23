@extends ('layouts.admin')
@section ('contenido')
    <section class="page-init">
        <h3>Listado de Ingresos</h3>
        @can('newIncomes')
            <a href="ingreso/create" class="btn btn-success btn-bg">
                Ingreso de stock
            </a>
        @endcan
    </section>

    <section class="section-content">
        <table class="table-sortable" id="table-info">
            <thead>
            <th onclick="sortTable(0)">
              Fecha
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(1)">
              Proveedor
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
              Impuesto
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(4)">
              Total
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th onclick="sortTable(5)">
              Estado
              <span class="pull-right-container">
                <i class="fa fa-angle-down pull-right icon-nav"></i>
              </span>
            </th>
            <th>Opciones</th>
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
