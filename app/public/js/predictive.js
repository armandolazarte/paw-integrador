window.addEventListener("load", function(){

    // Add a keyup event listener to our input element
    var name_input = document.getElementById('articulo');
    name_input.addEventListener("keyup", function(event){hinter(event)});

    // create one global XHR object
    // so we can abort old requests when a new one is make
    window.hinterXHR = new XMLHttpRequest();
});

// Autocomplete for form
function hinter(event) {

    // retireve the input element
    var input = event.target;

    // retrieve the datalist element
    var huge_list = document.getElementById('search_list');

    // minimum number of characters before we start to generate suggestions
    var min_characters = 0;

    if (input.value.length < min_characters ) {
        return;
    } else {

        // abort any pending requests
        window.hinterXHR.abort();

        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse( this.response );
                // clear any previously loaded options in the datalist
                huge_list.innerHTML = "";

                data = response.data

                data.forEach(function(item) {
                    // Create a new <option> element.
                    var option = document.createElement('option');
                    option.value = item.nombre;

                    var input = document.getElementById('pidarticulo');
                    input.value = item.idarticulo;

                    // // attach the option to the datalist element
                    huge_list.appendChild(option);
                });
            }
        };
        let endpoint = url + '/almacen/articulo';
        window.hinterXHR.open("GET", endpoint + "?json=true&searchText=" + input.value, true);
        window.hinterXHR.send()
    }
}
