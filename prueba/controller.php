<?php

include "Clase.php";

$c = Clase::getInstance();

if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
} else {
    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];
    } else {
        $accion = "bienvenida";
    }
}

if ($accion == "bienvenida") {
    echo file_get_contents("prueba.html");
}

if ($accion == "trae") {
    $c->algo("Quiero este texto");
}