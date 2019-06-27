{!! Form::open(array('url'=>'almacen/articulo','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}

<div class="form-group">
	<div class="input-group">
		<input type="text" class="form-control" id="filter" onkeyup="filterTable()" name="searchText" placeholder="Buscar..." value="{{$searchText}}">
		{{--<span class="input-group-btn">
			<button type="submit" class="btn btn-md btn-action">Buscar</button>
		</span>--}}
	</div>
</div>

{{Form::close()}}
