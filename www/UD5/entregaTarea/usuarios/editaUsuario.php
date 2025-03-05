<?php
require_once(__DIR__ . '/../login/sesiones.php');
if (!checkAdmin()) redirectIndex();

require_once(__DIR__ . '/../utils.php');
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$username = $_POST['username'];
$contrasena = $_POST['contrasena'];
$rol = $_POST['rol'];

require_once(__DIR__ . '/../modelo/Usuario.php');

$usuario = new Usuario($nombre, $apellidos, $username, $contrasena, $rol);
$usuario->setId($id);

// Validacion de campos con los metodos de la clase Usuario

if(empty($contrasena)){
    $errores = $usuario->validarSinContrasena();
}
else{
    $errores = $usuario->validar();
}

$error = false;
$message = '';

if (!empty($errores)) {
    foreach ($errores as $err) {
        // Mensajes del array de valicion del objeto usuario
        $message .= '<div class="alert alert-danger" role="alert">' . htmlspecialchars($err) . '</div>';
    }
    $error = true;
} else {
    require_once(__DIR__ . '/../modelo/pdo.php');

    $resultado = actualizaUsuario($usuario);

    if ($resultado[0])
    {
        $message = 'Usuario actualizado correctamente.';
    }
    else
    {
        $message = 'Ocurrió un error actualizando el usuario: ' . $usuario->getUsername();
        $error = true;
    }
}

/*
    if ($resultado[0]) {
        // Mensaje de exito
        $message = '<div class="alert alert-success" role="alert">Usuario guardado correctamente.</div>';
    } else {
        // Mensaje de error
        $message = '<div class="alert alert-danger" role="alert">Ocurrió un error guardando el usuario: ' . $resultado[1] . '</div>';
        $error = true;
    }
}
    */

$status = $error ? 'error' : 'success';
header("Location: editaUsuarioForm.php?id=$id&status=$status&message=$message");
