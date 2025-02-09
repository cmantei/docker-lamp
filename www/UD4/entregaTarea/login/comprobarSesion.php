<?php
session_start();
if (!isset($_SESSION['usuario'])) {	
    header("Location: ../login/login.php?redirect=true");
    exit();
}
$tema = isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'light';
?>