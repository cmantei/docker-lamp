<?php

require_once(__DIR__ . '/Usuario.php');

function conectaPDO()
{
    $servername = $_ENV['DATABASE_HOST'];
    $username = $_ENV['DATABASE_USER'];
    $password = $_ENV['DATABASE_PASSWORD'];
    $dbname = $_ENV['DATABASE_NAME'];

    $conPDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conPDO;
}

function listaUsuarios()
{
    try {
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT id, username, nombre, apellidos, rol, contrasena FROM usuarios');
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $resultados = $stmt->fetchAll();

        $usuarios = [];
        foreach ($resultados as $fila){
            $usuario = new Usuario();

            $usuario->setId($fila['id']);
            $usuario->setUsername($fila['username']);
            $usuario->setNombre($fila['nombre']);
            $usuario->setApellidos($fila['apellidos']);
            $usuario->setRol($fila['rol']);
            $usuario->setContrasena($fila['contrasena']);

            $usuarios[] = $usuario;

        }

        return [true, $usuarios];
    }
    catch (PDOException $e) {
        return [false, $e->getMessage()];
    }
    finally {
        $con = null;
    }
    
}

function listaTareasPDO($id_usuario, $estado)
{
    try {
        $con = conectaPDO();
        $sql = 'SELECT * FROM tareas WHERE id_usuario = ' . $id_usuario;
        if (isset($estado))
        {
            $sql = $sql . " AND estado = '" . $estado . "'";
        }
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $tareas = array();
        while ($row = $stmt->fetch())
        {
            $usuario = buscaUsuario($row['id_usuario']);
            $row['id_usuario'] = $usuario['username'];
            array_push($tareas, $row);
        }
        return [true, $tareas];
    }
    catch (PDOException $e) {
        return [false, $e->getMessage()];
    }
    finally {
        $con = null;
    }
    
}

function nuevoUsuario($usuario)
{
    try{
        $con = conectaPDO();
        $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, username, rol, contrasena) VALUES (:nombre, :apellidos, :username, :rol, :contrasena)");
        
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $username = $usuario->getUsername();
        $rol = $usuario->getRol();
        $contrasena = $usuario->getContrasena();

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':rol', $rol);
        $hasheado = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bindParam(':contrasena', $hasheado);
        $stmt->execute();
        
        $stmt->closeCursor();

        return [true, null];
    }
    catch (PDOException $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function actualizaUsuario($usuario)
{
    try {
        $con = conectaPDO();
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, username = :username, rol = :rol";

        if (!empty($usuario->getContrasena())) 
        {
            $sql = $sql . ', contrasena = :contrasena';
        }

        $sql = $sql . ' WHERE id = :id';

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':nombre', $usuario->getNombre());
        $stmt->bindValue(':apellidos', $usuario->getApellidos());
        $stmt->bindValue(':username', $usuario->getUsername());
        $stmt->bindValue(':rol', $usuario->getRol());

        if (!empty($usuario->getContrasena())) 
        {
            $hasheado = password_hash($usuario->getContrasena(), PASSWORD_DEFAULT);
            $stmt->bindValue(':contrasena', $hasheado);
        }

        $stmt->bindValue(':id', $usuario->getId());

        $stmt->execute();
        $stmt->closeCursor();

        return [true, null];
    } 
    catch (PDOException $e) 
    {
        return [false, $e->getMessage()];
    } 
    finally 
    {
        $con = null;
    }
}


function borraUsuario($usuario)
{
    try {
        $con = conectaPDO();

        $con->beginTransaction();

        $stmt = $con->prepare('DELETE FROM tareas WHERE id_usuario = ' . $usuario->getId());
        $stmt->execute();
        $stmt = $con->prepare('DELETE FROM usuarios WHERE id = ' . $usuario->getId());
        $stmt->execute();
        
        return [$con->commit(), ''];
    }
    catch (PDOException $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}

function buscaUsuario($id)
{

    try
    {
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT id, username, nombre, apellidos, rol, contrasena FROM usuarios WHERE id = ' . $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1)
        {
            $fila = $stmt->fetch();

            $usuario = new Usuario();
            $usuario->setId($fila['id']);
            $usuario->setUsername($fila['username']);
            $usuario->setNombre($fila['nombre']);
            $usuario->setApellidos($fila['apellidos']);
            $usuario->setRol($fila['rol']);
            $usuario->setContrasena($fila['contrasena']);

            return [true, $usuario];
        }
        else
        {
            return null;
        }
    }
    catch (PDOException $e)
    {
        return null;
    }
    finally
    {
        $con = null;
    }
    
}

function buscaUsername($username)
{
    try
    {
        $con = conectaPDO();
        $stmt = $con->prepare('SELECT id, rol, contrasena FROM usuarios WHERE username = "' . $username . '"');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 1)
        {
            return $stmt->fetch();
        }
        else
        {
            return null;
        }
    }
    catch (PDOException $e)
    {
        return null;
    }
    finally
    {
        $con = null;
    }
    
}

function listaFicheros($id_tarea)
{
    try
    {
        $con = conectaPDO();
        $sql = 'SELECT * FROM ficheros WHERE id_tarea = ' . $id_tarea;
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $ficheros = array();
        while ($row = $stmt->fetch())
        {
            array_push($ficheros, $row);
        }
        return $ficheros;
    }
    catch (PDOException $e)
    {
        return array();
    }
    finally
    {
        $con = null;
    }
}

function buscaFichero($id)
{
    try
    {
        $con = conectaPDO();
        $sql = 'SELECT * FROM ficheros WHERE id = ' . $id;
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $fichero = null;
        if ($row = $stmt->fetch())
        {
            $fichero = $row;
        }
        return $fichero;
    }
    catch (PDOException $e)
    {
        return null;
    }
    finally
    {
        $con = null;
    }
}

function borraFichero($id)
{
    try
    {
        $con = conectaPDO();
        $sql = 'DELETE FROM ficheros WHERE id = ' . $id;
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return true;
    }
    catch (PDOException $e)
    {
        return false;
    }
    finally
    {
        $con = null;
    }
}

function nuevoFichero($file, $nombre, $descripcion, $idTarea)
{
    try
    {
        $con = conectaPDO();
        $stmt = $con->prepare("INSERT INTO ficheros (nombre, file, descripcion, id_tarea) VALUES (:nombre, :file, :descripcion, :idTarea)");
        $stmt->bindParam(':file', $file);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':idTarea', $idTarea);
        $stmt->execute();
        
        $stmt->closeCursor();

        return [true, null];
    }
    catch (PDOException $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
        $con = null;
    }
}