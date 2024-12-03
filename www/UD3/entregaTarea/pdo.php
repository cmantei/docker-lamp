<?php
function conectaTareas()
{
    $servername = 'db';
    $username = 'root';
    $password = 'test';
    $dbname = 'tareas';

    $conPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conPDO;
}

function listaUsuarios() {
    try {
        $conexion = conectaTareas();
        $sql = "SELECT id, username, nombre, apellidos FROM usuarios";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    } finally {
        $conexion = null;
    }
}

function insertarUsuario($username, $nombre, $apellidos, $contrasena) {
    try {
        $conexion = conectaTareas();
        $stmt = $conexion->prepare(
            "INSERT INTO usuarios (username, nombre, apellidos, contrasena) 
            VALUES (:username, :nombre, :apellidos, :contrasena)"
        );
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':contrasena', $contrasena);

        return $stmt->execute();
    }catch (PDOException $e){
        return false;
    }finally {
        $conexion = null;
    }
}

function borrarTarea($id) {
    try {
        $conexion = conectaTareas();
        $sql = "DELETE FROM tareas WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;

    }catch (PDOException $e) {
        return false;
    }finally{
        $conexion = null;
    }
}

function borrarUsuario($id_usuario) {
    try {
        $conexion = conectaTareas();
        $conexion->beginTransaction();

        $sqlTareas = "DELETE FROM tareas WHERE id_usuario = :id_usuario";
        $stmtTareas = $conexion->prepare($sqlTareas);
        $stmtTareas->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmtTareas->execute();

        $sqlUsuario = "DELETE FROM usuarios WHERE id = :id_usuario";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmtUsuario->execute();

        $conexion->commit();
        return true;

    } catch (PDOException $e) {
        return false;
    } finally{
        $conexion = null;
    }
}

function recuperarUsuarioPorId($id) {
    try {
        $conexion = conectaTareas();
        $sql = "SELECT id, username, nombre, apellidos FROM usuarios WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    } finally {
        $conexion = null;
    }
}

function actualizarUsuario($id, $username, $nombre, $apellidos, $contrasena = null) {
    try{
        $conexion = conectaTareas();
        if (!empty($contrasena)) {
            $sql = "UPDATE usuarios SET username = :username, nombre = :nombre, apellidos = :apellidos, contrasena = :contrasena WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        return $stmt->execute();
        }else{
            $sql = "UPDATE usuarios SET username = :username, nombre = :nombre, apellidos = :apellidos WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            return $stmt->execute();
        }

    } catch (PDOException $e) {
        return null;
    } finally {
        $conexion = null;
    }
}
