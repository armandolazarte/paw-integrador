{!! Form::open(array('url'=>'compras/proveedor','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}

<div class="table-search">
		<span class="fa fa-search search-icon"></span>
		<input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-info"><span class="fa fa-search"></span></button>
		</span>
</div>

{{Form::close()}}