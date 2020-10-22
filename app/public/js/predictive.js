function predictiveList(inp, endpoint, inputValue) {

    console.log(inputValue)
    
    var currentFocus;
    /* Agrego event listener en on write del input */
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;

        /* Cierro todas las listas abiertas */
        closeAllLists();

        /* Si no hay valor salgo */
        if (!val) { return false;}
        
        /* Si la cantidad de menor a 3 salgo */
        if (val.length < 3 ) { return false;}

        currentFocus = -1;

        /* Creo un DIV para meter todos los items de la lista dentro */
        list = document.createElement("DIV");
        list.setAttribute("id", this.id + "autocomplete-list");
        list.setAttribute("class", "autocomplete-items");
    
        /* Agrego la list al span container */
        this.parentNode.appendChild(list);


        /* Aborto todas las request anteriores */
        window.hinterXHR.abort();

        /* Cuando el request este listo */
        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse( this.response );
            
                data = response.data

                data.forEach(function(item) {
                    // // Create a new <option> element.
                    b = document.createElement("DIV");
                    
                    b.innerHTML = "<strong>" + item.nombre.substr(0, val.length) + "</strong>";
                    b.innerHTML += item.nombre.substr(val.length);
          
                    b.innerHTML += "<input type='hidden' value='" + item.id + "' data-text='" + item.nombre + "'>";
          
                    b.addEventListener("click", function(e) {
                        /* Inserto el value del autocomplete en el text field */
                        let inputClicked = this.getElementsByTagName("input")[0];
                        /* Agarro el input hidden */
                        let inputHiddenValue = document.getElementById(inputValue);
                        /* Le inserto el value */
                        inputHiddenValue.value = inputClicked.value;
                        inputHiddenValue.dispatchEvent(new Event('change'));
                        /* Al input que muestra el texto*/
                        inp.value = inputClicked.dataset.text;
                        
                        /* Cierro todas las listas abiertas */
                        closeAllLists();

                    });
                    list.appendChild(b);
                });
            }
        };

        let endpoint = url + '/almacen/articulo';
        window.hinterXHR.open("GET", endpoint + "?json=true&searchText=" + val, true);
        window.hinterXHR.send()

    });

    /* Escucho las teclas del teclado */
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          /*Si la tecla hacia abajo es presionada,
          aumento el foco acutal de item*/
          currentFocus++;
          /*y sombre el item visible*/
          addActive(x);
        } else if (e.keyCode == 38) { //up
          /*Si la tecla hacia arriba es presionada,
          decremento el foco:*/
          currentFocus--;
          /*y sombre el item visible*/
          addActive(x);
        } else if (e.keyCode == 13) {
          /*Si el enter es presionado, hago un prevent default del FORM*/
          e.preventDefault();
          if (currentFocus > -1) {
            /* simulo click en el item */
            if (x) x[currentFocus].click();
          }
        }
    });

    /* Funcione que pinta de activo el item actual que estoy navegando */
    function addActive(x) {
      if (!x) return false;
      /* Remuevo los items inactivos menos el actual */
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      /*agrego la clase que lo hace activo*/
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      /* Quito la clase que lo hace activo al item*/
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }

    function closeAllLists(elmnt) {
      /* Elimino todos los elementos con la clase menos el que se pasa por paramentro */
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }

    /*Si se clickea por fuera cierro todas las listas predictivas */
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

let input = document.getElementById("inputText");
let endpoint = input.dataset.endpoint;
let inputvalue = input.dataset.inputvalue;
 /* Creo elemento de request de manera global */
window.hinterXHR = new XMLHttpRequest();

/* Llamo a la funcion predictiva */
predictiveList(input, endpoint, inputvalue);