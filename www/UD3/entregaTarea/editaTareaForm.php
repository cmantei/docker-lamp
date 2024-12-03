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
                    <h2>Formulario para actualizar tareas SIN IMPLEMENTAR</h2>
                </div>
                <div class="container">
                
                <form class="mb-5" method="POST" action="editaTarea.php">

                    <div class="mb-3">
                        <label class="form-label">Titulo</label>
                        <input class="form-control" type="text" name="titulo"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <input class="form-control" type="text" name="descripcion"/>
                    </div>

                    <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select" name="estado">
                        <option value="pendiente">Pendiente</option>
                        <option value="proceso">En proceso</option>
                        <option value="completada">Completada</option>
                    </select>
                    </label>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
                </form>
                </div>
            </main>
        </div>
    </div>
    <!--footer-->
    <?php include "footer.php";?>
</body>
</html>