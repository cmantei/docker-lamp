<?php
include_once('../login/comprobarSesion.php');
require_once('../modelo/mysqli.php');

$tarea = null;
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $tarea = buscaTarea($id);
}

if (!$tarea) {
    echo "<div class='alert alert-danger'>No se encontró la tarea.</div>";
    exit();
}
require_once('../modelo/pdo.php');
$archivos = listaFicheros($id)[1];
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="<?php echo $tema; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalles de la Tarea</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include_once('../vista/header.php'); ?>
    
  <div class="container-fluid">
    <div class="row">
      <?php include_once('../vista/menu.php'); ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="pt-3 pb-2 mb-3 border-bottom">
          <h2>Detalles de la Tarea</h2>
        </div>

        <!-- Datos de la tarea -->
        <div class="mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($tarea['titulo']); ?></h5>
              <p class="card-text">
                <strong>Descripción:</strong> <?php echo htmlspecialchars($tarea['descripcion']); ?>
              </p>
              <p class="card-text">
                <strong>Estado:</strong> <?php echo htmlspecialchars($tarea['estado']); ?>
              </p>
            </div>
          </div>
        </div>

        <!-- Archivos Adjuntos -->
        <div class="mb-4">
          <h4>Archivos Adjuntos</h4>
          <a href="../ficheros/subidaFichForm.php?id_tarea=<?php echo $id; ?>" class="btn btn-primary mb-3">
            Añadir nuevo archivo
          </a>

          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if (!empty($archivos)) { 
              foreach ($archivos as $archivo) { ?>
                <div class="col">
                  <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                      <h5 class="card-title"><?php echo htmlspecialchars($archivo['nombre']); ?></h5>
                      <p class="card-text"><?php echo htmlspecialchars($archivo['descripcion']); ?></p>
                      <div class="mt-auto">
                        <a href="../../../files/<?php echo $archivo['file']; ?>" download class="btn btn-sm btn-primary">
                          Descargar
                        </a>
                        <a href="../ficheros/borrarFichero.php?id=<?php echo $archivo['id']; ?>&id_tarea=<?php echo $id; ?>" class="btn btn-sm btn-danger">
                          Borrar
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
            <?php } 
            } else { ?>
              <div class="col-12">
                <p>No hay archivos adjuntos.</p>
              </div>
            <?php } ?>
          </div>
        </div>
      </main>
    </div>
  </div>

  <?php include_once('../vista/footer.php'); ?>
</body>
</html>