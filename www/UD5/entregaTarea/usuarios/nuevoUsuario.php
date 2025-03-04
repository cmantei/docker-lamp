<?php
require_once('../login/sesiones.php');
if (!checkAdmin()) redirectIndex();
    
require_once('../utils.php');
$nombre = filtraCampo($_POST['nombre']);
$apellidos = filtraCampo($_POST['apellidos']);
$username = filtraCampo($_POST['username']);
$contrasena = $_POST['contrasena'];
$rol = $_POST['rol'];

require_once('./modelo/Usuario.php');

$usuario = new Usuario($nombre, $apellidos, $username, $contrasena, $rol);

$errores = $usuario->validar();

$error = false;
$message = 'Error creando el usuario.';

if (!empty($errores)){
    foreach ($errores as $error) {
        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($error) . '</div>';
    }
    $error = true;
}
else{
    require_once('../modelo/pdo.php');
    $resultado = nuevoUsuario($usuario);
    if ($resultado[0])
    {
        echo '<div class="alert alert-success" role="alert">Usuario guardado correctamente.</div>';
    }
    else
    {
        echo '<div class="alert alert-danger" role="alert">Ocurrió un error guardando el usuario: ' . $resultado[1] . '</div>';
        $error = true;
    }
}
$status = $error ? 'error' : 'success';
header("Location: nuevoUsuarioForm.php?status=$status&message=$message");

