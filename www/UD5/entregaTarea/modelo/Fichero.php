<?php

class Fichero {
    private $id;
    private $nombre;
    private string $file;
    private $descripcion;
    private Tarea $tarea;

    public static $FORMATOS = ['image/jpeg', 'image/png', 'application/pdf'];
    public static $MAX_SIZE = 20*1024*1024;

    public function __construct($nombre, string $file, $descripcion, Tarea $tarea) {
        $this->nombre = $nombre;
        $this->file = $file;
        $this->descripcion = $descripcion;
        $this->tarea = $tarea;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function getFile() {
        return $this->file;
    }
    public function setFile($file) {
        $this->file = $file;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function getTarea() {
        return $this->tarea;
    }
    public function setTarea(Tarea $tarea) {
        $this->tarea = $tarea;
    }

    public function validar(array $archivo) {
        $errors = [];
    
        if (empty($this->nombre) || empty($this->descripcion) || empty($this->tarea)) {
            $errors['campos'] = "Todos los campos son obligatorios.";
        }
    
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $errors['subida'] = "Error al subir el archivo.";
        }
    
        if ($archivo['size'] > self::$MAX_SIZE) {
            $errors['tamaño'] = "Error: El archivo excede el tamaño máximo permitido de 20 MB.";
        }
    
        if (!in_array($archivo['type'], self::$FORMATOS)) {
            $errors['formato'] = "Formato de archivo no permitido. Se permiten JPG, PNG y PDF.";
        }
    
        return $errors;
    }
    


}
?>