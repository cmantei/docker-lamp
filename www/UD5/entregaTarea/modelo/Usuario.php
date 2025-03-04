<?php

class Usuario{
    
    private $id;
    private $nombre;
    private $apellidos;
    private $username;
    private $contrasena;
    private $rol;

    public function __construct($nombre = '', $apellidos = '', $username = '', $contrasena = '', $rol = ''){
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->username = $username;
        $this->contrasena = $contrasena;
        $this->rol = $rol;

    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getUsername(){
        return $this->username;
    }
    public function setUsername($username){
        $this->username = $username;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getApellidos(){
        return $this->apellidos;
    }
    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    public function getContrasena(){
        return $this->contrasena;
    }
    public function setContrasena($contrasena){
        $this->contrasena = $contrasena;
    }

    public function getRol(){
        return $this->rol;
    }
    public function setRol($rol){
        $this->rol = $rol;
    }

    public function validar(): array {

        $errores = [];
        
        if(empty($this->username) || !is_string($this->username) || strlen($this->username)< 3){
            $errores['username'] = 'El username es obligatorio y debe tener al menos 3 caracteres de longitud.';
        }
        if(empty($this->nombre) || !is_string($this->nombre) || strlen($this->nombre)< 3){
            $errores['nombre'] = 'El nombre es obligatorio y debe tener al menos 3 caracteres de longitud.';
        }
        if(empty($this->apellidos) || !is_string($this->apellidos) || strlen($this->apellidos)< 3){
            $errores['apellidos'] = 'Los apellidos son obligatorios y deben tener al menos 3 caracteres de longitud.';
        }

        if(empty($this->contrasena) || !is_string($this->contrasena) || strlen($this->contrasena)< 6){
            $errores['contrasena'] = 'La contraseña tiene que tener al menos 6 caracteres de longitud';
        }

        if(empty($this->rol)){
            $errores['rol'] = 'Es necesario seleccionar un rol para continuar';
        }

        return $errores;

    }

}


?>