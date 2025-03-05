<?php
require_once(__DIR__ . '/../login/sesiones.php');
require_once(__DIR__ . '/../modelo/Tarea.php');
require_once(__DIR__ . '/../modelo/Fichero.php');
require_once(__DIR__ . '/../modelo/mysqli.php');


$directorioDestino = "files/"; // Carpeta donde se guardarán los archivos --> revisar permisos si da error

$location = '../tareas.php';
$response = 'error';
$messages = array();

$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $nombreArchivo = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $archivo = $_FILES['archivo'] ?? null;
    $id_tarea = $_POST['id_tarea'] ?? '';
    $location = 'subidaFichForm.php?id=' . $id_tarea;

    // Validación y creación del nombre final
    $codigoAleatorio = bin2hex(random_bytes(8));
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreFinal = $codigoAleatorio . '.' . $extension;
    $rutaDestino = $directorioDestino . $nombreFinal;

    // Verificación de permisos en el directorio
    if (!is_writable('../' . $directorioDestino))
    {
        array_push($messages, "No hay permisos de escritura en la carpeta destino.");
        $error = true;
    }

    // Mover el archivo al directorio de destino
    if (!$error)
    {
        if (move_uploaded_file($archivo['tmp_name'], '../' . $rutaDestino))
        {
            require_once('../modelo/pdo.php');

            $tarea = buscaTarea($id_tarea);
            if (!$tarea) {
                array_push($messages, 'Tarea no encontrada.');
                $error = true;
            }

            if (!$error) {
                $fichero = new Fichero($nombreArchivo, $rutaDestino, $descripcion, $tarea);
                
                $errores = $fichero->validar($archivo);
                if (count($errores) > 0) {
                    $error = true;
                    $messages = array_merge($messages, $errores);
                }
            }

            if (!$error) {
                $resultado = nuevoFichero($fichero);

                if ($resultado[0])
                {
                    $response = 'success';
                    array_push($messages, 'Archivo subido correctamente.');
                    $location = '../tareas/tarea.php?id=' . $id_tarea;
                }
                else
                {
                    array_push($messages, 'Ocurrió un error guardando el fichero: ' . $resultado[1] . '.');
                }
            }
        }
        else
        {
            array_push($messages, 'Error al guardar el archivo.');
        }
    }
}
else
{
    array_push($messages, 'Método de solicitud no válido.');
}

$_SESSION['status'] = $response;
$_SESSION['messages'] = $messages;
header("Location: " . $location);
?>
