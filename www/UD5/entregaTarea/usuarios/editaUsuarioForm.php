<?php
    require_once(__DIR__ . '/../login/sesiones.php');
    if (!checkAdmin()) redirectIndex();
?>
    <?php include_once(__DIR__ . '/../vista/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once(__DIR__ . '/../vista/menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Actualizar usuario</h2>
                    <?php include_once (__DIR__ . '/../vista/erroresGet.php'); ?>
                </div>

                <div class="container justify-content-between">
                    <form action="editaUsuario.php" method="POST" class="mb-5 w-50">
                        <?php
                        require_once(__DIR__ . '/../modelo/pdo.php');
                        require_once(__DIR__ . '/../modelo/Usuario.php');

                        if (!empty($_GET))
                        {
                            $id = $_GET['id'];
                            $usuario = buscaUsuario($id);
                            if (!empty($id) && $usuario[0])
                            {
                                $nombre = $usuario[1]->getNombre();
                                $apellidos = $usuario[1]->getApellidos();
                                $username = $usuario[1]->getUsername();
                                $rol = $usuario[1]->getRol();
                        ?>
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <?php include_once(__DIR__ . '/formUsuario.php'); ?>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" >
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        <?php
                            }
                            else
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información de la tarea.</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger" role="alert">Debes acceder a través del listado de tareas.</div>';
                        }
                        ?>
                    </form>

                </div>
            </main>
        </div>
    </div>

    <?php include_once(__DIR__ . '/../vista/footer.php'); ?>
    
</body>
</html>
