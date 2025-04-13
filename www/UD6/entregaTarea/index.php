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

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $token = bin2hex(random_bytes(32));

    $sql = "INSERT INTO usuarios(nombre, email, password, token) VALUES (:nombre, :email, :password, :token)";
    $sentencia = Flight::db()->prepare($sql);
    
    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":email", $email);
    $sentencia->bindParam(":password", $passwordHash);
    $sentencia->bindParam(":token", $token);

    $sentencia->execute();

    Flight::jsonp(["Usuario registrado correctamente"]);
});

// Consultar usuarios
Flight::route('GET /usuarios', function(){
    $sentencia = Flight::db()->prepare("SELECT * FROM usuarios");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

// Iniciar sesion con un usuario. Crea un token único cada login asociado al usuario, actualiza la BD y lo devuelve en la cabecera de la peticion
Flight::route('POST /login', function(){

    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;

    $sentencia = Flight::db()->prepare("SELECT password FROM usuarios WHERE email = :email");
    $sentencia->bindParam(':email', $email);
    $sentencia->execute();

    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        //Equivalente a stop mas exit mas mensaje
        Flight::halt(404, 'Usuario no encontrado.');
    }

    if (!password_verify($password, $usuario['password'])) {
        Flight::halt(401, 'Contraseña incorrecta.');
    }

    $token = bin2hex(random_bytes(32));

    $update = Flight::db()->prepare("UPDATE usuarios SET token = :token WHERE email = :email");
    $update->bindParam(':token', $token);
    $update->bindParam(':email', $email);
    $update->execute();

    $sentencia = Flight::db()->prepare("SELECT * FROM usuarios WHERE email = :email");
    $sentencia->bindParam(':email', $email);
    $sentencia->execute();
    $datosUsuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    Flight::set('user', $datosUsuario);

    Flight::response()->header('X-Token', $token);
    Flight::json(['Inicio de sesion con exito']);

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
        Flight::halt(401, 'Acceso no autorizado. Es necesario un token valido');
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

// Añadir contactos si el usuario esta autenticado (token enviado en la cabecera se encuentra en la base de datos)
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
            Flight::halt(404, 'El contacto solicitado no existe en la base de datos');
        }

        if($datosContacto['usuario_id'] != $id_usuario){
            Flight::halt(403, 'Acceso a contacto no autorizado');
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
        Flight::halt(404, 'El contacto solicitado no existe en la base de datos');
    }

    if($datosContacto['usuario_id'] != $id_usuario){
        Flight::halt(403, 'Acceso a contacto no autorizado');
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
Flight::start();
?>