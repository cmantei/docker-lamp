<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD3. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!--header-->
    <?php include "header.php";?>
    <div class="container-fluid">
        <div class="row">
            <!--menu-->
            <?php include "menu.php";?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Formulario para actualizar usuarios</h2>
                </div>
                <div class="container">
                    <p>Rellenar los siguientes campos (mínimo 3 y máximo 50 caracteres por campo):</p>
                    <?php
                    require_once('pdo.php');
                    if (isset($_GET['id'])){
                        $id = $_GET['id'];
                    }
                    $usuario = recuperarUsuarioPorId($id);
                    ?>
                    <form class="mb-5" method="POST" action="editaUsuario.php">

                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($usuario['username']); ?>"/>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>"/>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellidos</label>
                            <input class="form-control" type="text" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>"/>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input class="form-control" type="password" name="contrasena"/>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <!--footer-->
    <?php include "footer.php";?>
</body>
</html>