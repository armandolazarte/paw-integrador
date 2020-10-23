window.addEventListener("load", function(){
    //Obtengo el input search
    let searchs_inputs = document.getElementsByClassName('search-ajax');

    for (i = 0; i < searchs_inputs.length; i++) {

        let endpoint = searchs_inputs[i].dataset.endpoint;
        let editurl = searchs_inputs[i].dataset.editurl;
        searchs_inputs[i].addEventListener("keyup", function(event){searchAjax(event, endpoint, editurl)});

    }

    let filter_selects = document.getElementsByClassName('filter-select');

    for (i = 0; i < filter_selects.length; i++) {

        let endpoint = filter_selects[i].dataset.endpoint;
        let editurl = filter_selects[i].dataset.editurl;
        filter_selects[i].addEventListener("change", function(event){filterAjax(event, endpoint, editurl)});

    }



    // Se crea objeto XHR global para que corte es caso de que se haga una nueva
    window.hinterXHR = new XMLHttpRequest();
});

// Autocomplete for form
function searchAjax(event, endpoint, editUrl) {

    /* Me quedo con el event target*/ 
    var input = event.target;

        // Aborto request
        window.hinterXHR.abort();

        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse( this.response );

                data = response.data


                let tbody = document.getElementById('tablebody');
                tbody.innerHTML = '';

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

                    let listItem = document.createElement('td');
                    listItem.classList.add('td-controls');

                    editUrl = editUrl.replace('#', item.id)

                    listItem.innerHTML = '<a href="'+editUrl+'" class="btn btn-alert btn-md">Editar</a> \
                                            <a href="" class="btn btn-danger btn-md">Eliminar</a>';
                    tableRow.appendChild(listItem);

                    tbody.appendChild(tableRow);

                });
            }
        };
        let url_search = url + endpoint;

        window.hinterXHR.open("GET", url_search + '?query=' +input.value, true);
        window.hinterXHR.send()

}

// Autocomplete for form
function filterAjax(event, endpoint, editUrl) {

    /* Me quedo con el event target*/ 
    var input = event.target;

        // Aborto request
        window.hinterXHR.abort();

        window.hinterXHR.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var response = JSON.parse( this.response );

                data = response.data


                let tbody = document.getElementById('tablebody');
                tbody.innerHTML = '';

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

                    let listItem = document.createElement('td');
                    listItem.classList.add('td-controls');

                    listItem.innerHTML = '<a href="'+editUrl+'/'+item.id+'" class="btn btn-alert btn-md">Editar</a> \
                                            <a href="" class="btn btn-danger btn-md">Eliminar</a>';
                    tableRow.appendChild(listItem);

                    tbody.appendChild(tableRow);

                });
            }
        };
        let url_search = url + endpoint;

        window.hinterXHR.open("GET", url_search + '?filterCategory=' +input.value, true);
        window.hinterXHR.send()

}