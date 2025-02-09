<?php
if (!isset($tema)) {
    $tema = isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'light';
}
?>
<nav class="col-md-3 col-lg-2 d-md-block <?php echo ($tema === 'light') ? 'bg-light' : ''; ?> sidebar">
    <div class="position-sticky">
        <!-- Formulario para cambiar el tema -->
        <form action="/UD4/entregaTarea/tema.php" method="post" class="m-3">
            <div class="mb-2">
                <label for="tema" class="form-label">Selecciona el tema:</label>
                <select id="tema" name="tema" class="form-select">
                    <option value="light" <?php echo ($tema === 'light') ? 'selected' : ''; ?>>Claro</option>
                    <option value="dark" <?php echo ($tema === 'dark') ? 'selected' : ''; ?>>Oscuro</option>
                    <option value="auto" <?php echo ($tema === 'auto') ? 'selected' : ''; ?>>Automático</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Aplicar</button>
        </form>

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