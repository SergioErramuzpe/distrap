window.onload = function init() {
    fetchTextos();
}

function fetchTextos() {
    texto = document.getElementById('texto1');
    $.get('controller.php?accion=trae',function (plantilla) {
        texto.innerText= "asdfasdfas";
    });
}



    function f1 () {
        texto = document.getElementById('texto1');
        $.get('controller.php?accion=trae',function (plantilla) {
            texto.innerText = plantilla;
        });
    }

function f2 () {
    texto = document.getElementById('texto2');
    $.get('controller.php', {'accion':'trae'},function (plantilla) {
        texto.innerText = "XD";
    });
}
