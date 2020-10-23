<div class="table-filter">
		<select name="idcategoria" class="form-control filter-select" 
			data-filter="true" data-endpoint="/api/articulos" 
			data-editurl="/api/articulo/#/edit" data-deleteurl="/api/articulo/#/edit">
					<option value="">Filtrar por categoría</option>
					@foreach ($categorias as $cat)
						<option value="{{$cat->idcategoria}}">{{$cat->nombre}} </option>
					@endforeach
				</select>
</div>

<div class="table-search">
		<span class="fa fa-search search-icon"></span>
		<input type="text" id="search" placeholder="Buscar..." class="search-ajax"
					data-endpoint="/api/articulos" 
					data-editurl="/api/articulo/#/edit" data-deleteurl="/api/articulo/#/edit" 
					name="searchText">
</div>
