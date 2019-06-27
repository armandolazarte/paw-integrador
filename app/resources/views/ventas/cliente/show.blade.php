@extends ('layouts.admin')
@section ('contenido')
<section class="page-content">
	<div class="form-group">
			<label for="proveedor">Cliente</label>
			<p>{{$cliente->nombre}}</p>

				<label>Tipo de Cliente</label>
				<p>{{$cliente->tipo_persona}}</p>

				<label >Tipo de Documento</label>
				<p>{{$cliente->tipo_documento}}</p>

				<label >Número de Documento</label>
				<p>{{$cliente->num_documento}}</p>
	</div>

	<h3><u>Historial de Ventas</u></h3>
	<table class="table">
		<thead>
			<th>Fecha</th>
			<th>Cliente</th>
			<th>Tipo Comprobante</th>
			<th>Total</th>
			<th>Estado</th>
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
				<a href="{{URL::action('VentaController@show',$ven->idventa)}}" target="_blank" class="btn btn-info btn-md">
						Detalles
				</a>
				@can('destroyProveedores')
					<a href="{URL::action('VentaController@destroy',$ven->idventa)}" class="btn btn-danger btn-md">
						Anular
					</a>
				@endcan
			</td>
		</tr>
		@endforeach
	</table>

</section>

@endsection
