<?php
include_once('../login/comprobarSesion.php');

$id_tarea = $_GET['id_tarea'];
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="<?php echo $tema; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('../vista/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('../vista/menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">
                    <h2>Subir Archivo</h2>
                    <form action="subidaFichProc.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_tarea" value="<?php echo $id_tarea; ?>">

                        <div class="mb-3">
                            <label for="archivo" class="form-label">Selecciona un archivo (JPG, PNG, PDF)</label>
                            <input type="file" class="form-control" name="archivo" required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Introduce un nombre" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4" placeholder="Introduce una descripción" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mb-3">Subir</button>
                        <a href="../tareas/tarea.php?id=<?php echo $id_tarea; ?>" class="btn btn-secondary mb-3">Volver</a>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php include_once('../vista/footer.php'); ?>

</body>
</html>