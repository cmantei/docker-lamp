<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarea UD4 Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once('../vista/header.php'); ?>

    <main class="d-flex justify-content-center align-items-center flex-grow-1 p-4 m-4">
                
        <div class="card shadow p-4 w-100" style="max-width:400px">
            
            <h2 class="text-center mb-4">Iniciar sesión</h2>

            <?php
            //Comprobar si se reciben datos
            $redirect = isset($_GET['redirect']) ? true : false;
            $error = isset($_GET['error']) ? true : false;
            $message = isset($_GET['message']) ? $_GET['message'] : null;
            if ($redirect)
            {
                echo '<div class="alert alert-danger" role="alert">Debes iniciar sesión para acceder.</div>';
            }
            elseif ($error)
            {
                if ($message)
                {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . $message . '</div>';
                }
                else
                {
                    echo '<div class="alert alert-danger" role="alert">Usuario y contraseña incorrectos.</div>';
                }
            }
            ?>

            <form action="loginAuth.php" method="POST" class="needs-validation text-center">
                <div class="mb-3">
                    <input name="usuario" id="usuario" type="text" class="form-control" placeholder="usuario" required>
                </div>
                <div class="mb-3">
                    <input name="pass" id="pass" type="password" class="form-control" placeholder="contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
            </form>
            
        </div>
    
    </main>    

  <?php include_once('../vista/footer.php'); ?>

</body>
</html>
