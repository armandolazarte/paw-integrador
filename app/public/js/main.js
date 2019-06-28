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
    tableElement = document.getElementsByClassName("table-sortable");
    table = tableElement[0];

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