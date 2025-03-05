<?php
require_once(__DIR__ . '/../login/sesiones.php');
require_once(__DIR__ . '/../utils.php');
require_once(__DIR__ . '/../modelo/mysqli.php');
require_once(__DIR__ . '/../modelo/pdo.php');
require_once(__DIR__ . '/../modelo/Tarea.php');


$titulo = filtraCampo($_POST['titulo']);
$descripcion = filtraCampo($_POST['descripcion']);
$estado = filtraCampo($_POST['estado']);
$id_usuario = filtraCampo($_POST['id_usuario']);

$usuario = buscaUsuario($id_usuario)[1];

if (!$usuario) {
    $_SESSION['status'] = 'error';
    $_SESSION['messages'] = ['No se encontró el usuario'];
    header("Location: nuevaForm.php");
    exit;
}

$tarea = new Tarea($titulo, $descripcion, $estado, $usuario);

$errores = $tarea->validar();

if(!empty($errores)){
    $_SESSION['status'] = 'error';
    $_SESSION['messages'] = $errores;
    header("Location: nuevaForm.php");
    exit;
}

$resultado = nuevaTarea($tarea);

if ($resultado[0]) {
    $_SESSION['status'] = 'success';
    $_SESSION['messages'] = ['Tarea guardada correctamente.'];
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['messages'] = ['Ocurrió un error guardando la tarea: ' . $resultado[1]];
}

header("Location: nuevaForm.php");
exit;