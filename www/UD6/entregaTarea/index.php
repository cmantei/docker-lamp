<?php
require_once 'flight/Flight.php';
// require 'flight/autoload.php';
$host = $_ENV['DATABASE_HOST'];
$name = $_ENV['DATABASE_NAME'];
$user = $_ENV['DATABASE_USER'];
$pass = $_ENV['DATABASE_PASSWORD'];

Flight::register('db', 'PDO', array("mysql:host=$host;dbname=$name", $user, $pass));

// Registrar usuarios
Flight::route('POST /register', function(){

    $nombre = Flight::request()->data->nombre;
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;

    if(!$nombre || !$email || !$password){
        Flight::json(["Incluye los campos nombre, email y password en la solicitud."], 400);
        Flight::stop();
        exit();
    }

    $stmt = Flight::db()->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $emailRegistrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if($emailRegistrado){
        Flight::json(["Ya existe un usuario registrado con ese email."], 400);
        Flight::stop();
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $token = bin2hex(random_bytes(32));

    $sql = "INSERT INTO usuarios(nombre, email, password, token) VALUES (:nombre, :email, :password, :token)";
    $sentencia = Flight::db()->prepare($sql);
    
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":email", $email);
    $sentencia->bindParam(":password", $passwordHash);
    $sentencia->bindParam(":token", $token);

    $sentencia->execute();

    Flight::json(["Usuario $email registrado correctamente"]);
});

/*
// Consultar usuarios
Flight::route('GET /usuarios', function(){
    $sentencia = Flight::db()->prepare("SELECT * FROM usuarios");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});
*/

// Iniciar sesion con un usuario. Crea un token único cada login asociado al usuario, actualiza la BD y lo devuelve en la cabecera de la peticion
Flight::route('POST /login', function(){

    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;

    if(!$email || !$password){
        Flight::json(["Incluye los campos email y password en la solicitud para iniciar sesion."], 400);
        Flight::stop();
        exit();
    }

    $sentencia = Flight::db()->prepare("SELECT password FROM usuarios WHERE email = :email");
    $sentencia->bindParam(':email', $email);
    $sentencia->execute();

    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        Flight::json(["No existe un usuario registrado con el email proporcionado"], 404);
        Flight::stop();
        exit();
    }

    if (!password_verify($password, $usuario['password'])) {
        Flight::json(["La contraseña no es correcta"], 401);
        Flight::stop();
        exit();
    }

    $token = bin2hex(random_bytes(32));

    $update = Flight::db()->prepare("UPDATE usuarios SET token = :token WHERE email = :email");
    $update->bindParam(':token', $token);
    $update->bindParam(':email', $email);
    $update->execute();

    Flight::response()->header('X-Token', $token);
    Flight::json(["Inicio de sesion del usuario $email con exito. Se ha enviado el token de autenticacion en la cabecera de la respuesta."]);
});

function buscarUsuario(){
    $token = Flight::request()->getHeader('X-Token');

    if (empty($token)){
        return false;
    }

    $sql = "SELECT * from usuarios WHERE token = :token";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(':token', $token);
    $sentencia->execute();
    $datosUsuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    return $datosUsuario;
}

function verificarUsuario(){
    $datosUsuario = buscarUsuario();

    if(!$datosUsuario){
        Flight::json(["Acceso no autorizado. Es necesario un token valido."], 401);
        Flight::stop();
        exit();
    }
    return $datosUsuario;
}

function devolverContacto($id_contacto){
    $sentencia = Flight::db()->prepare("SELECT * from contactos WHERE id = :id");
    $sentencia->bindParam(":id", $id_contacto);
    $sentencia->execute();
    $datos = $sentencia->fetch(PDO::FETCH_ASSOC);
    return $datos;
}

// Añadir contactos si el token enviado por el usuario en la cabecera se encuentra en la base de datos, lo que acredita su autenticacion
Flight::route('POST /contactos', function(){

    $datosUsuario = verificarUsuario();

    $nombre = Flight::request()->data->nombre;
    $telefono = Flight::request()->data->telefono;
    $email = Flight::request()->data->email;
    $usuario_id = $datosUsuario['id'];
    
    $sql = "INSERT INTO contactos (nombre, telefono, email, usuario_id) VALUES (:nombre, :telefono, :email, :usuario_id)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":email", $email);
    $sentencia->bindParam(":usuario_id", $usuario_id);

    $sentencia->execute();
    Flight::json(["Contacto registrado correctamente"]);
});

// Listar los contactos del usuario autenticado
Flight::route('GET /contactos(/@id)', function($id = null){

    $datosUsuario = verificarUsuario();
    $id_usuario = $datosUsuario['id'];
    if($id){
        $datosContacto = devolverContacto($id);

        if(!$datosContacto){
            Flight::json(["No se encuentra el contacto en la base de datos"], 404);
            Flight::stop();
            exit();
        }

        if($datosContacto['usuario_id'] != $id_usuario){
            Flight::json(["No esta autorizado a acceder al contacto indicado"], 403);
            Flight::stop();
            exit();
        }

        Flight::json($datosContacto);

    }else{
        $sentencia = Flight::db()->prepare("SELECT * from contactos WHERE usuario_id = :usuario_id");
        $sentencia->bindParam(":usuario_id", $id_usuario);
        $sentencia->execute();
        $datosContactos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        Flight::json($datosContactos);
    }
});

// Actualizar los contactos del usuario autenticado
Flight::route('PUT /contactos', function(){
    
    $datosUsuario = verificarUsuario();
    $id_usuario = $datosUsuario['id'];

    $id = Flight::request()->data->id;
    $nombre = Flight::request()->data->nombre;
    $telefono = Flight::request()->data->telefono;
    $email = Flight::request()->data->email;

    $datosContacto = devolverContacto($id);

    if(!$datosContacto){
        Flight::json(["No se encuentra el contacto en la base de datos"], 404);
        Flight::stop();
        exit();
    }

    if($datosContacto['usuario_id'] != $id_usuario){
        Flight::json(["No esta autorizado a acceder al contacto indicado"], 403);
        Flight::stop();
        exit();
    }

    $sql = "UPDATE contactos set nombre = :nombre, telefono = :telefono, email = :email WHERE id = :id";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":email", $email);
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();

    Flight::json(["Informacion de contacto actualizada correctamente."]);

});

Flight::route('DELETE /contactos', function(){
    $id = Flight::request()->data->id;
    $datosContacto = devolverContacto($id); 
    $datosUsuario = verificarUsuario();
    $id_usuario = $datosUsuario['id'];

    if(!$datosContacto){
        Flight::json(["No se encuentra el contacto en la base de datos"], 404);
        Flight::stop();
        exit();
    }

    if($datosContacto['usuario_id'] != $id_usuario){
        Flight::json(["No esta autorizado a acceder al contacto indicado"], 403);
        Flight::stop();
        exit();
    }

    $sentencia = Flight::db()->prepare("DELETE FROM contactos WHERE id = :id");
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();

    Flight::json(["Contacto con id $id eliminado"]);
});

Flight::start();
?>