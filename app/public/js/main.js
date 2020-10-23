/*

MENU -  SUBMENU

*/
var dropdown = document.getElementsByClassName('dropdown');
for (var i in dropdown) {
    dropdown[i].onclick = function (e) {
        e.preventDefault();
        var nav = this.getElementsByClassName('icon-nav')[0];
        var submenu = this.nextElementSibling;
        if (submenu.classList.contains('open')) {
            submenu.classList.remove('open');
            nav.classList.remove('fa-angle-down');
            nav.classList.add('fa-angle-left');
        } else {
            submenu.classList.add('open');
            nav.classList.remove('fa-angle-left');
            nav.classList.add('fa-angle-down');
        }

    }
}

/* NOTIFICATIONS */

function readNotifications(url, all, id) {

    var xhttp = new XMLHttpRequest();
    xhttp.abort();
    xhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
           console.log(this.response)
        var response = JSON.parse( this.response );
        return response;
        }
      };

    if (all) {
        xhttp.open('GET', url, true);
        xhttp.send();
    } else {
        xhttp.open('POST', url, true);
        xhttp.setRequestHeader('Content-Type', 'application/json');
        let data = {};
        data.idarticulo = id;
        xhttp.send(JSON.stringify(data));
    }
 }

 function getAllNotifications() {

    window.hinterXHR = new XMLHttpRequest();
    // Aborto request
    window.hinterXHR.abort();
    window.hinterXHR.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {

        var response = JSON.parse( this.response );
        data = response.notificaciones
        let notification_counter = document.getElementById('notification-counter');
        let notification_list = document.getElementById('notification-list');
        notification_list.innerHTML = '';
        
        notification_counter.innerHTML = data.length;
        if (data.length > 0) {
            notification_counter.classList.add('alert');
            data.forEach(function(item) {
                let liElement = document.createElement('li');
                liElement.dataset.id = item.id;
                liElement.innerHTML = item.msj;
                /* En el on click de una notificacion redirecciono a la vista de ese articulo */
                liElement.addEventListener("click", function(e) {
                    let url_notif = url + '/api/notificaciones/read';
                    readNotifications(url_notif, false, item.id);
                    updateNotifications();
                });
                notification_list.appendChild(liElement);
            });
            let liElement = document.createElement('li');
            liElement.id = -1;
            liElement.innerHTML = 'Marcar todas leídas';
            liElement.addEventListener("click", function(e) {
                let url_notif = url + '/api/notificaciones/read_all';
                readNotifications(url_notif, true, null);
                updateNotifications();

            });
            notification_list.appendChild(liElement);
        } else {
            if (notification_counter.classList.contains('alert')) {
                notification_counter.classList.remove('alert');
            }
        }

    }
    };

    let url_notifications = url + '/api/notificaciones/all';
    window.hinterXHR.open("GET", url_notifications, true);
    window.hinterXHR.send()

}

getAllNotifications();

var notification_button = document.getElementById('notification-button');
    notification_button.onclick = function (e) {
        e.preventDefault();
        var submenu = this.nextElementSibling;
        if (submenu.classList.contains('open')) {
            submenu.classList.remove('open');
        } else {
            submenu.classList.add('open');
        }
    }

function updateNotifications() {
    getAllNotifications();
    let notification_button = document.getElementById('notification-button');
    notification_button.dispatchEvent(new Event('click'));
}


/* STICKY BUTTON */

var sticky = document.getElementById('sticky-menu');
sticky.onclick = function (e) {
    var nav = document.getElementsByClassName('sidenav')[0];
    if (nav.classList.contains('open')) {
        nav.classList.remove('open');
    } else {
        nav.classList.add('open');
    }
}

/*

  ON DELETE

*/

function destroy(e, name) {
  e.preventDefault();
  if (confirm('Está seguro que desea eliminar: ' + name)) {
      window.location.href = e.target.href;
  }
}

/*

  Ordeando de tabla

*/

function sortTable(n) {
    var table, tableElement, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("table-info");

    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
        let elementClicked = event.target;
        if (elementClicked.classList.contains('fa')) {
          iconElement = elementClicked;
        } else {
          iconElement = (elementClicked.children)[0].children[0];
        }
        if (dir == "asc") {
          iconElement.classList = 'fa fa-angle-down pull-right icon-nav';
        } else {
          iconElement.classList = 'fa fa-angle-up pull-right icon-nav';;
        }
    }
}

function filterTable() {

    var input, filter, table, tr, td, i;
    input = document.getElementById("filter");
    filter = input.value.toUpperCase();
    table = document.getElementById("table-info");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        // Hide the row initially.
        tr[i].style.display = "none";

        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            cell = tr[i].getElementsByTagName("td")[j];
            if (cell) {
                if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}

/*

THUMBNAILS

*/

var thumbs = document.getElementsByClassName('thumbs');
for (var i in thumbs) {
    thumbs[i].onmouseover = function (e) {

      let hover = document.createElement('div');
      hover.id = 'thumb-hover';
      hover.style.left = (e.clientX + 25) + 'px';
      hover.style.top = (e.clientY - 25) + 'px';
      hover.style.backgroundImage = 'url(' + this.src + ')';
      document.body.appendChild(hover);

    }

    thumbs[i].onmouseout = function (e) {

      var elem = document.getElementById('thumb-hover');
      return elem.parentNode.removeChild(elem);

    }
}
