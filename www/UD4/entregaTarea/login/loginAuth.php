<?php
session_start();

require_once('../modelo/pdo.php');

//Comprobar si se reciben los datos
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $usuario = $_POST["usuario"];
    $pass = $_POST["pass"];

    if (empty($usuario) || empty($pass))
    {
        header('Location: login.php?error=true&message=Los campos del formulario son obligatorios.');
    }

    // SUPERUSUARIO de pruebas
    if ($usuario === 'root' && $pass === 'test') {
        $_SESSION['usuario']['username'] = $usuario;
        $_SESSION['usuario']['rol'] = 1;
        header("Location: ../index.php");
        exit;
    }

    $conPDO = conectaPDO();
    if (is_string($conPDO))
    {
        header('Location: login.php?error=true&message=' . $conPDO);
    }
    $user = comprobarUsuario($usuario, $pass, $conPDO);
    if(!$user)
    {
        header('Location: login.php?error=true');
    }
    elseif (is_string($user))
    {
        header('Location: login.php?error=true&message=' . $user);
    }
    else
    {   
        // $user contiene $_SESSION['usuario']['nombre'], $_SESSION['usuario']['rol'] y $_SESSION['usuario']['id']
        $_SESSION['usuario'] = $user;
        header('Location: ../index.php');
    }
}





