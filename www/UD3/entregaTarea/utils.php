<?php
function filtrarCampos($campo) {
    $campo = trim($campo);
    $campo = stripslashes($campo);
    $campo = htmlspecialchars($campo);
    return $campo;
}
function validarCampos($campo) {
    $campo_filtrado = filtrarCampos($campo);
    if (!empty($campo_filtrado) && strlen($campo_filtrado) >= 3 && strlen($campo_filtrado) <= 50) {
        return true;
    } else {
        return false;
    }
}