window.onload = function() {
  document.getElementById("bt_add").addEventListener("click", function(){
    agregar();
  });
};



  var cont=0;
  total=0;
  subtotal=[];

  function agregar(){
    let art = document.getElementById("pidarticulo");
    let idarticulo = art.value;
    let articulo = document.getElementById("articulo").value;
    let cantidad  = document.getElementById("pcantidad").value;
    let precio_compra = document.getElementById("pprecio_compra").value;
    let precio_venta = document.getElementById("pprecio_venta").value;

    if(idarticulo !="" && cantidad !="" && cantidad>0 && precio_compra !="" && precio_venta !=""){
      subtotal[cont]=(cantidad*precio_compra);
      total=total+subtotal[cont];
      var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-alert" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_compra[]" value="'+precio_compra+'"><td><input type="number" name="precio_venta[]" value="'+precio_venta+'"><td>'+subtotal[cont]+'</td></tr>';
      limpiar();
      document.getElementById("total").innerHTML = "$/."+ total;
      evaluar();
      var table = document.getElementById("detalles");
      var newRow   = table.insertRow(table.rows.length - 1);
      newRow.id = 'fila'+cont;
      newRow.innerHTML = fila;
      cont++;
    }else{
      alert("Error al ingresar el detalle del ingreso, revise los datos del articulo");

    }
  }
  function limpiar(){
    document.getElementById("pcantidad").value = '';
    document.getElementById("pprecio_compra").value = '';
    document.getElementById("pprecio_venta").value = '';
  }

  function evaluar(){
    if(total>0){
      document.getElementById("guardar").style.cssText = 'display: inline-block';
    }else{
      document.getElementById("guardar").style.cssText = 'display: none';
    }
  }

  function eliminar(index){
    total=total-subtotal[index];
    document.getElementById("total").innerHTML = "$/."+ total;
    let fila = document.getElementById("fila"+index)
    fila.parentNode.removeChild(fila);
    evaluar();
  }
