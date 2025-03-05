<?php

require_once(__DIR__ . '/../utils.php');

class Usuario{
    
    private $id;
    private $nombre;
    private $apellidos;
    private $username;
    private $contrasena;
    private $rol;

    public function __construct($nombre = '', $apellidos = '', $username = '', $contrasena = '', $rol = 0){
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
    
        // Verificar el campo nombre
        if (!validarCampoTexto($this->nombre)) {
            $errores['nombre'] = 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.';
        }
    
        // Verificar el campo apellidos
        if (!validarCampoTexto($this->apellidos)) {
            $errores['apellidos'] = 'El campo apellidos es obligatorio y debe contener al menos 3 caracteres.';
        }
    
        // Verificar el campo username
        if (!validarCampoTexto($this->username)) {
            $errores['username'] = 'El campo username es obligatorio y debe contener al menos 3 caracteres.';
        }
    
        // Verificar el campo contraseña
        if (!validaContrasena($this->contrasena)) {
            $errores['contrasena'] = 'El campo contraseña es obligatorio y debe ser compleja.';
        }
    
        // Verificar rol
        if ($this->rol != 0 && $this->rol != 1) {
            $errores['rol'] = 'Es necesario seleccionar un rol para continuar.';
        }
    
        return $errores;
    }
    
    public function validarSinContrasena(): array {
        $errores = [];
    
        // Verificar el campo nombre
        if (!validarCampoTexto($this->nombre)) {
            $errores['nombre'] = 'El campo nombre es obligatorio y debe contener al menos 3 caracteres.';
        }
    
        // Verificar el campo apellidos
        if (!validarCampoTexto($this->apellidos)) {
            $errores['apellidos'] = 'El campo apellidos es obligatorio y debe contener al menos 3 caracteres.';
        }
    
        // Verificar el campo username
        if (!validarCampoTexto($this->username)) {
            $errores['username'] = 'El campo username es obligatorio y debe contener al menos 3 caracteres.';
        }
    
        // Verificar rol
        if ($this->rol != 0 && $this->rol != 1) {
            $errores['rol'] = 'Es necesario seleccionar un rol para continuar.';
        }
    
        return $errores;
    }
    
    

}


?>