<?php
require_once(__DIR__ . '/../login/sesiones.php');
if (!checkAdmin()) redirectIndex();

require_once(__DIR__ . '/../utils.php');

$nombre = filtraCampo($_POST['nombre']);
$apellidos = filtraCampo($_POST['apellidos']);
$username = filtraCampo($_POST['username']);
$contrasena = $_POST['contrasena'];
$rol = $_POST['rol'];

require_once(__DIR__ . '/../modelo/Usuario.php');

$usuario = new Usuario($nombre, $apellidos, $username, $contrasena, $rol);

// Validacion de campos con el metodo validar de usuario
$errores = $usuario->validar();

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
    $resultado = nuevoUsuario($usuario);
    if ($resultado[0]) {
        // Mensaje de exito
        $message = '<div class="alert alert-success" role="alert">Usuario guardado correctamente.</div>';
    } else {
        // Mensaje de error
        $message = '<div class="alert alert-danger" role="alert">Ocurrió un error guardando el usuario: ' . $resultado[1] . '</div>';
        $error = true;
    }
}

// Estado de exito o error
$status = $error ? 'error' : 'success';

// Redirigimos mensajes por GET
header("Location: nuevoUsuarioForm.php?status=$status&message=" . urlencode($message));
exit();


