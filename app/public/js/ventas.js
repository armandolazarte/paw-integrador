window.onload = function() {

  document.getElementById("bt_add").addEventListener("click", function(){
    addProduct();
  });

  console.log("HOLA")

  document.getElementById('pidarticulo').addEventListener('change', function(){
    console.log("Hola")
    chargeValues();
  });

};

var cont=0;
total=0;
subtotal=[];

function chargeValues(){
  let id = document.getElementById('pidarticulo').value;
  if (id) {
    let request = new XMLHttpRequest();
    let endpoint = url + '/almacen/articulo/' + id;
    request.open('Get', endpoint);
    request.send();
    request.onreadystatechange = function() {
      if(request.readyState === 4) {
        if(request.status === 200) {
          let art = JSON.parse(request.response)[0];
          document.getElementById('pprecio_venta').value = art.precio_promedio;
          document.getElementById('pstock').value = art.stock;
        } else {
          alert("Hubo un error");
        }
      }
    }
  }

}

  function addProduct(){

    let idarticulo=document.getElementById('pidarticulo').value;
    articulo = document.getElementById('inputText').value;
    cantidad = document.getElementById("pcantidad").value;
    descuento = document.getElementById("pdescuento").value;
    precio_venta = document.getElementById("pprecio_venta").value;
    stock= document.getElementById("pstock").value;

    if(idarticulo !="" && cantidad !="" && cantidad>0 && descuento !="" && precio_venta !=""){
      if(parseInt(stock) > parseInt(cantidad)){

        subtotal[cont]=(cantidad*precio_venta) - descuento;
        total=total+subtotal[cont];

        var fila='<tr class="selected" id="fila'+cont+'"> \
                    <td><button type="button" class="btn btn-alert" onclick="eliminar('+cont+');">X</button></td> \
                    <td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td> \
                    <td><input type="number" name="cantidad[]" value="'+cantidad+'"></td> \
                    <td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td> \
                    <td><input type="number" name="descuento[]" value="'+descuento+'"></td> \
                    <td>'+subtotal[cont]+'</td> \
                  </tr>';
        limpiar();
        document.getElementById("total").innerHTML = "$/."+ total;
        document.getElementById("total_venta").value = total;
        evaluar();
        var table = document.getElementById("detalles");
        var newRow   = table.insertRow(table.rows.length - 1);
        newRow.id = 'fila'+cont;
        newRow.innerHTML = fila;
        cont++;
      }else{
        alert("Stock Insuficiente");
      }
    }else{
      alert("Error al ingresar el detalle de la venta, revise los datos del articulo");
    }
  }


  function limpiar(){
    document.getElementById('pidarticulo').value = '';
    document.getElementById("pcantidad").value = '';
    document.getElementById("pdescuento").value = '';
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
    document.getElementById("total_venta").value = total;
    let fila = document.getElementById("fila"+index)
    fila.parentNode.removeChild(fila);
    evaluar();
  }
