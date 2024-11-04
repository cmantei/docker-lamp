<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD2. Tarea</title>
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
                    include "utils.php";
                    
                    $id = $_POST['id'];
                    $descripcion = $_POST['descripcion'];
                    $estado = $_POST['estado'];
                                        
                    $mensaje = guardar_tareas($id, $descripcion, $estado);
                    echo '<p>'.$mensaje.'</p>';
                    ?>
                    <p>Tabla para comprobar que se guardaron los campos del formulario en el array:</p>
                    <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>                            
                            <th>Identificador</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php devolver_lista_tareas($tareas);?>
                    </tbody>
                </div>
            </main>
        </div>
    </div>
    <!--footer-->
    <?php include "footer.php";?>
</body>
</html>