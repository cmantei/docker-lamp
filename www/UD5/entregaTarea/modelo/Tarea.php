<?php

class Tarea{

    private $id;
    private $titulo;
    private $descripcion;
    private $estado;
    private $usuario;

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





}

?>