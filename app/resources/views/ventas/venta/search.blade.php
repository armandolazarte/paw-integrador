{!! Form::open(array('url'=>'ventas/venta','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}

<div class="table-filter">
		<input type="number" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-info btn-search">Buscar<span class="fa fa-search"></span></button>
		</span>
</div>

{{Form::close()}}