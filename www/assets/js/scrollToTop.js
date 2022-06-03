
//Obtenemos el boton
var botonScroll = document.getElementById("botonScroll");

// Cuando el usuario se desplace 20 píxeles hacia abajo desde la parte superior de la página se mostrará el botón.
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        botonScroll.style.display = "block";
    } else {
        botonScroll.style.display = "none";
    }
}

// Cuando el usuario haga click en el boton hará un scroll hacia arriba de la página.
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}