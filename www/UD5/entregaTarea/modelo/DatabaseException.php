<?php

class DatabaseException extends Exception {

    private $method;
    private $sql;

    public function __construct($mensaje, $codigo = 0, Exception $anterior = null, $method = '', $sql = '') {
        parent::__construct($mensaje, $codigo, $anterior);
        $this->method = $method;
        $this->sql = $sql;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getSql() {
        return $this->sql;
    }

    public function setSql($sql) {
        $this->sql = $sql;
    }
    
}
?>
