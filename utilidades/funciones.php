<?php

/**
 * @author Soraya León González
 * IES TRASSIERRA
 */

function alerta($texto) {
    echo '<script type="text/javascript">alert("' . $texto . '")</script>';
}

// Filtrado de datos de formulario
function filtrado($datos) {
    $datos = trim($datos); // Elimina espacios
    $datos = stripslashes($datos); // Elimina backslashes \
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    return $datos;
}

// Codifica en base64
function encode($str){
    return urlencode(base64_encode($str));
}
//Decodifica en base64
function decode($str){
    return base64_decode(urldecode($str));
}

