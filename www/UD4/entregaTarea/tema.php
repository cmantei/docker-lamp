<?php
if (isset($_POST['tema'])) {
    
    $tema = $_POST['tema'];
    $temas = ['light', 'dark', 'auto'];
    if (!in_array($tema, $temas)) {
        $tema = 'light';
    }

    setcookie('tema', $tema, time() + (86400 * 30), '/');
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>