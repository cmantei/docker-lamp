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
                    <h2>Lista de Tareas</h2>
                </div>
                <div class="container">
                    <div class="table">
    <table class="table table-striped table-hover">
        <thead class="thead">
            <tr>                            
                <th>Identificador</th>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            if (isset($_GET['id_usuario'])) {
                $id = $_GET['id_usuario'];
                require_once('pdo.php');
                $tareas = filtrarTareas($id);
            } else {
                require_once('mysqli.php');
                $tareas = listarTareas();
            }
            if (!empty($tareas)){
                foreach ($tareas as $tarea) {
                    echo "<tr>";
                        echo "<td>".$tarea['id']."</td>";
                        echo "<td>".$tarea['titulo']."</td>";
                        echo "<td>".$tarea['descripcion']."</td>";
                        echo "<td>".$tarea['estado']."</td>";
                        echo "<td>".$tarea['username']."</td>";
                        echo "<td>";
                        echo '<a class="btn btn-sm btn-outline-primary me-2" href="editaTareaForm.php?id=' . $tarea['id'] . '" role="button">Editar</a>';
                        echo '<a class="btn btn-sm btn-outline-danger" href="borraTarea.php?id=' . $tarea['id'] . '" role="button">Borrar</a>';
                        echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
        </tbody>
                </div>
            </main>
        </div>
    </div>
    <!--footer-->
    <?php include "footer.php";?>
</body>
</html>