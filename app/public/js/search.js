window.addEventListener("load", function(){
    //Obtengo el input search
    let searchs_inputs = document.getElementsByClassName('search-ajax');

    for (i = 0; i < searchs_inputs.length; i++) {

        let endpoint = searchs_inputs[i].dataset.endpoint;
        searchs_inputs[i].addEventListener("keyup", function(event){searchAjax(event, endpoint)});

    }

    // Se crea objeto XHR global para que corte es caso de que se haga una nueva
    window.hinterXHR = new XMLHttpRequest();
});

// Autocomplete for form
function searchAjax(event, endpoint) {

    /* Me quedo con el event target*/ 
    var input = event.target;

        // Aborto request
        window.hinterXHR.abort();

        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse( this.response );

                data = response.data
                data.forEach(function(item) {

                   // create a table row element
                    let tableRow = document.createElement('tr');

                    Object.keys(item).map(key => {

                        let listItem = document.createElement('td');
                        listItem.classList.add('td-' + key);

                        let innerTD = '';
                        if (key == 'imagen') {
                            innerTD = '<img src="/imagenes/articulos/'+ item[key] +'" class="thumbs">'
                        } else {
                            innerTD = item[key];
                        }

                        listItem.innerHTML = innerTD;
                        tableRow.appendChild(listItem);
                        
                    });

                    let tbody = document.getElementById('tablebody');
                    tbody.innerHTML = '';
                    tbody.appendChild(tableRow);

                    console.log(tableRow)

                });
            }
        };
        let url_search = url + endpoint;

        window.hinterXHR.open("GET", url_search + '?query=' +input.value, true);
        window.hinterXHR.send()

}
