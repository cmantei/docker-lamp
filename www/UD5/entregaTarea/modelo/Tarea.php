<?php

require_once(__DIR__ . '/../utils.php');

class Tarea{

    private $id;
    private $titulo;
    private $descripcion;
    private $estado;
    private Usuario $usuario;

    public function __construct($titulo, $descripcion, $estado, Usuario $usuario){
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->usuario = $usuario;
    }


    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario){
        $this->usuario = $usuario;
    }


    public function validar(): array {
        $errores = [];

        if (!validarCampoTexto($this->titulo)) {
            $errores['titulo'] = 'El campo título es obligatorio y debe contener al menos 3 caracteres.';
        }
        if (!validarCampoTexto($this->descripcion)) {
            $errores['descripcion'] = 'El campo descripción es obligatorio y debe contener al menos 3 caracteres.';
        }
        if (!validarCampoTexto($this->estado)) {
            $errores['estado'] = 'El campo estado es obligatorio.';
        }
        if (!$this->usuario instanceof Usuario || !esNumeroValido($this->usuario->getId())) {
            $errores['usuario'] = 'El campo usuario no es válido.';
        }

        return $errores;
    }


}

?>