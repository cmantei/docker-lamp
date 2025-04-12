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
    Flight::json([
        'mensaje' => 'Inicio de sesión exitoso',
        'token' => $token
    ]);

});

// Añadir contactos si el usuario esta autenticado (token enviado en la cabecera se encuentra en la base de datos)
Flight::route('POST /contactos', function(){

    $token = Flight::request()->getHeader('X-Token');

    $sql = "SELECT * from usuarios WHERE token = :token";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(':token', $token);
    $sentencia->execute();
    $datosUsuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ((!$datosUsuario) || ($datosUsuario['token'] != $token)){
        Flight::halt(403, 'Acceso denegado');

    }else{
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
    }
});
Flight::start();
?>