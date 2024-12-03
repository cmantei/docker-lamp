<?php             
function crearBaseDatos(){
    try {
        $conexion = new mysqli('db', 'root', 'test');
        if($conexion->connect_error){
            return [false, $conexion->error];
        }else{
            echo 'Conexión correcta<br>';
        }
        $sql = 'CREATE DATABASE IF NOT EXISTS tareas';
        if ($conexion->query($sql)) {
            echo 'Base de datos tareas creada correctamente <br>';
        }
        else {
            echo 'Error creando la base de datos: ' . $conexion->error . '<br>';
        }
    }
    catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }
    finally {
        $conexion->close();
    }
}

function crearTablasUsuariosTareas(){
    try{
        $conexion = new mysqli('db', 'root', 'test', 'tareas');
        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        `id` INT NOT NULL AUTO_INCREMENT,
        `username` VARCHAR(50) NOT NULL,
        `nombre` VARCHAR(50) NOT NULL,
        `apellidos` VARCHAR(100) NOT NULL,
        `contrasena` VARCHAR(100) NOT NULL,
        PRIMARY KEY (`id`))";
        if($conexion->query($sql)){
            echo "Tabla usuarios creada con exito<br>";
        }else{
            echo "Error creando tabla usuarios".$conexion->error;
        }
        $sql = "CREATE TABLE IF NOT EXISTS tareas (
        id INT NOT NULL AUTO_INCREMENT,
        titulo VARCHAR(50) NOT NULL,
        descripcion VARCHAR(250) NOT NULL,
        estado VARCHAR(50) NOT NULL,
        id_usuario INT,
        PRIMARY KEY (id),
        FOREIGN KEY (id_usuario) references usuarios(id)
        )";
        if($conexion->query($sql)){
            echo "Tabla tareas creada con exito<br>";
        }else{
            echo "Error creando tabla tareas".$conexion->error;
        }
    }catch (mysqli_sql_exception $e){
        return [false, $e->getMessage()];
    }finally{
            $conexion->close();
    }
}

function conectaTareas(){
    $conexion = new mysqli('db', 'root', 'test', 'tareas');
    return $conexion;
}

function listarUsuarios() {
    try {
        $conexion = new mysqli('db', 'root', 'test', 'tareas');
        if($conexion->connect_error){
            return [false, $conexion->error];
        }
        $sql = "SELECT id, username FROM usuarios";
        $resultados = $conexion->query($sql);
        return $resultados->fetch_all(MYSQLI_ASSOC);
    } catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    } finally {
            $conexion->close();    
    }
}

function guardarTarea($titulo, $descripcion, $estado, $id_usuario) {
    try {      
        $conexion = new mysqli('db', 'root', 'test', 'tareas');
        if($conexion->connect_error){
            return [false, $conexion->error];
        }  
        $sql = "INSERT INTO tareas (titulo, descripcion, estado, id_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('sssi', $titulo, $descripcion, $estado, $id_usuario);
        if ($stmt->execute()) {
            return true; 
        } else {
            return false;  
        }
    }catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }finally{
        $conexion->close();
    }

}

function listarTareas() {
    try {
        $conexion = new mysqli('db', 'root', 'test', 'tareas');
        if($conexion->connect_error){
            return [false, $conexion->error];
        }
        $sql = "SELECT tareas.id, tareas.titulo, tareas.descripcion, tareas.estado, usuarios.username FROM tareas JOIN usuarios ON tareas.id_usuario = usuarios.id";
        $resultados = $conexion->query($sql);
        return $resultados->fetch_all(MYSQLI_ASSOC);
    } catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    } finally {
            $conexion->close();    
    }
}