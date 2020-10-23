@extends ('layouts.admin')
@section ('contenido')
<section class="page-content">
	<div class="form-group">
		<p>
			<b>Articulo:</b> {{$articulo->nombre}}
		</p>

		<p>
			<b>Cod:</b> {{$articulo->codigo}}
		</p>

		<p>
			<b>Descripción:</b> {{$articulo->descripcion}}
		</p>

		<p>
			<b>Stock Min:</b> {{$articulo->minStock}}
		</p>

		<p>
			<b>Stock Actual:</b> {{$articulo->stock}}
		</p>

		<p>
			<b>Precio:</b> {{$articulo->precio_venta}}
		</p>

		@if (($articulo->imagen)!="")
							<figure>
									<img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" height="250px" width="250px">
							</figure>
		@endif


	
	</div>

</section>


@endsection
