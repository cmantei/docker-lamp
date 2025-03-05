<?php
require_once(__DIR__ . '/../login/sesiones.php');
require_once(__DIR__ . '/../utils.php');
require_once(__DIR__ . '/../modelo/pdo.php');
require_once(__DIR__ . '/../modelo/mysqli.php');

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$estado = $_POST['estado'];
$id_usuario = $_POST['id_usuario'];

if (!checkAdmin()) {
    $id_usuario = $_SESSION['usuario']['id'];
}

$location = "editaTareaForm.php?id=$id";
$messages = [];

$usuario = buscaUsuario($id_usuario)[1];
$tarea = new Tarea($titulo, $descripcion, $estado, $usuario);
$tarea->setId($id);

$errores = $tarea->validar();
if (!empty($errores)) {
    $_SESSION['status'] = 'error';
    $_SESSION['messages'] = $errores;
} else {
    $resultado = actualizaTarea($tarea);
    $_SESSION['status'] = $resultado[0] ? 'success' : 'error';
    $_SESSION['messages'][] = $resultado[0] ? 'Tarea actualizada correctamente.' : "Ocurrió un error actualizando la tarea: $resultado[1].";
    if ($resultado[0]) {
        $location = 'tareas.php';
    }
}

header("Location: $location");
?>
