window.addEventListener("load", function(){
    //Obtengo el input search
    var name_input = document.getElementById('search');
    name_input.addEventListener("keyup", function(event){search(event)});

    // Se crea objeto XHR global para que corte es caso de que se haga una nueva
    window.hinterXHR = new XMLHttpRequest();
});

// Autocomplete for form
function search(event) {

    // retireve the input element
    var input = event.target;

    // minimum number of characters before we start to generate suggestions
    var min_characters = 0;

    if (input.value.length < min_characters ) {
        return;
    } else {

        // Aborto request
        window.hinterXHR.abort();

        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse( this.response );

                data = response.data
                console.log(data);
                data.forEach(function(item) {

                });
            }
        };
        let endpoint = url + '/almacen/articulo';
        window.hinterXHR.open("GET", endpoint + "?json=true&searchText=" + input.value, true);
        window.hinterXHR.send()
    }
}
