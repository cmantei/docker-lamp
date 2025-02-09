<?php
include_once('../login/comprobarSesion.php');
require_once('../modelo/pdo.php');

if (!empty($_GET['id']) && !empty($_GET['id_tarea'])) {
    
    $idArchivo = $_GET['id'];
    $idTarea = $_GET['id_tarea'];

    borrarFichero($idArchivo);
    header("Location: ../tareas/tarea.php?id=" . $idTarea);
    exit();
    
} else {
    header("Location: ../tareas/tareas.php");
    exit();
}
?>