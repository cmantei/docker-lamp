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
                    <h2>Resultado del formulario</h2>
                </div>
                <div class="container">
                    <?php
                       if (!empty($_POST)){
                        
                        require_once('utils.php');

                        $titulo = $_POST['titulo'];
                        $descripcion = $_POST['descripcion'];
                        $estado = $_POST['estado'];
                        $id_usuario = $_POST['id_usuario'];

                        // Validaciones
                        $error = false;
                        if (!validarCampos($titulo)){
                            $error = true;
                            echo '<div class="alert alert-danger" role="alert">Revisa el titulo.</div>';
                        }
                        if (!validarCampos($descripcion)){
                            $error = true;
                            echo '<div class="alert alert-danger" role="alert">Revisa la descripcion.</div>';
                        }
                        if (!$error){
                            require_once('mysqli.php');
                            
                            if (guardarTarea($titulo, $descripcion, $estado, $id_usuario)){
                                echo '<div class="alert alert-success" role="alert">Tarea registrada correctamente.</div>';
                            }else{
                                echo '<div class="alert alert-danger" role="alert">Ocurrió un error registrando la tarea.</div>';
                            }
                        }

                        }else{
                            echo '<div class="alert alert-warning" role="alert">No se pudo procesar el contenido del formulario.</div>';
                        }
                    ?>
                </div>
            </main>
        </div>
    </div>
    <!--footer-->
    <?php include "footer.php";?>
</body>
</html>