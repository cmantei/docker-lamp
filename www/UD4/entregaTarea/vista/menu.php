<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/index.php">Home</a>
            </li>

            <?php if ($_SESSION['usuario']['rol'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/UD4/entregaTarea/init.php">Inicializar (mysqli)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/UD4/entregaTarea/usuarios/usuarios.php">Lista de usuarios (PDO)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/UD4/entregaTarea/usuarios/nuevoUsuarioForm.php">Nuevo usuario (PDO)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/UD4/entregaTarea/tareas/buscaTareas.php">Buscador de tareas (PDO)</a>
                </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/tareas/tareas.php">Lista de tareas (mysqli)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/tareas/nuevaForm.php">Nueva tarea (mysqli)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/UD4/entregaTarea/login/logout.php">Salir</a>
            </li>
        </ul>
    </div>
</nav>
