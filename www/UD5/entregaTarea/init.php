<?php
    require_once(__DIR__ . '/login/sesiones.php');
    if (!checkAdmin()) header("Location: index.php?redirect=true");
?>
    <?php include_once(__DIR__ . '/vista/header.php'); ?>

    <div class="container-fluid">
        <div class="row">
        
        <?php include_once(__DIR__ . '/vista/menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Menú</h2>
                </div>

                <div class="container justify-content-between">
                    <?php
                        require_once(__DIR__ . '/modelo/mysqli.php');
                        $resultado = creaDB();
                        if ($resultado[0])
                        {
                            echo '<div class="alert alert-success" role="alert">';
                        }
                        else
                        {
                            echo '<div class="alert alert-warning" role="alert">';
                        }
                        echo $resultado[1];
                        echo '</div>';
                        $resultado = createTablaUsuarios();
                        if ($resultado[0])
                        {
                            echo '<div class="alert alert-success" role="alert">';
                        }
                        else
                        {
                            echo '<div class="alert alert-warning" role="alert">';
                        }
                        echo $resultado[1];
                        echo '</div>';
                        $resultado = createTablaTareas();
                        if ($resultado[0])
                        {
                            echo '<div class="alert alert-success" role="alert">';
                        }
                        else
                        {
                            echo '<div class="alert alert-warning" role="alert">';
                        }
                        echo $resultado[1];
                        echo '</div>';
                        $resultado = createTablaFicheros();
                        if ($resultado[0])
                        {
                            echo '<div class="alert alert-success" role="alert">';
                        }
                        else
                        {
                            echo '<div class="alert alert-warning" role="alert">';
                        }
                        echo $resultado[1];
                        echo '</div>';
                    ?>
                </div>
            </main>
        </div>
    </div>

    <?php include_once(__DIR__ . '/vista/footer.php'); ?>
    
</body>
</html>