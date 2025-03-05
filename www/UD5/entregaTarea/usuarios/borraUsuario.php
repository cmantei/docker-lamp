<?php
require_once(__DIR__ . '/../login/sesiones.php');
if (!checkAdmin()) redirectIndex();

$message = 'Error borrando el usuario.';
$error = true;

require_once(__DIR__ . '/../modelo/pdo.php');

if (!empty($_GET))
{
    $id = $_GET['id'];
    if (!empty($id))
    {
        $usuario = buscaUsuario($id);
        if ($usuario[0]){
            $resultado = borraUsuario($usuario[1]);

            if ($resultado[0])
            {
                $message = 'Usuario borrado correctamente.';
                $error = false;
            }
            else
            {
                $message = 'No se pudo borrar el usuario.';
            }

        }
    }
    else
    {
        $message = 'No se pudo recuperar la información del usuario.';
    }
}
else
{
    $message = 'Debes acceder a través del listado de usuarios.';
}

$status = $error ? 'error' : 'success';
header("Location: usuarios.php?status=$status&message=$message");
