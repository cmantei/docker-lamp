<?php
include_once('../login/comprobarSesion.php');

// Verificar que se ha enviado el archivo por POST y con el id de tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivo"]) && isset($_POST["id_tarea"])) {
    $id_tarea = $_POST["id_tarea"];
    $descripcion = $_POST["descripcion"];
    $nombre = $_POST["nombre"];
    $target_dir = "../../../files/";
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION));

    // Validar el tipo de archivo
    $formatosPermitidos = ["jpg", "jpeg", "png", "pdf"];
    if (!in_array($imageFileType, $formatosPermitidos)) {
        $uploadOk = 0;
    }

    // Validar el tamaño máximo (20MB)
    if ($_FILES["archivo"]["size"] > 20 * 1024 * 1024) {
        $uploadOk = 0;
    }

    // Si no hubo errores de validación se genera un nombre aleatorio y se mueve el archivo al directorio files
    if ($uploadOk) {
        $codigoAleatorio = bin2hex(random_bytes(8));
        $nuevoNombre = $codigoAleatorio . "." . $imageFileType;
        $target_file = $target_dir . $nuevoNombre;

        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
            require('../modelo/pdo.php');
            nuevoFichero($nombre, $target_file, $descripcion, $id_tarea);

            header("Location: ../tareas/tarea.php?id=" . $id_tarea);
            exit();
        }
    }

    header("Location: subidaFichForm.php?id_tarea=" . $id_tarea);
    exit();
} else {
    header("Location: ../tareas/tareas.php");
    exit();
}
?>