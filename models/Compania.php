<?php

namespace Model;

class Compania extends ActiveRecord {

    public static $tabla = 'kvsc_compania';
    public static $columnasDB = [
        'compania_nombre',
        'compania_integrantes',
        'compania_situacion'
    ];

    public static $idTabla = 'compania_id';
    public $compania_id;
    public $compania_nombre;
    public $compania_integrantes;
    public $compania_situacion;

    public function __construct($args = []){
        $this->compania_id = $args['compania_id'] ?? null;
        $this->compania_nombre = $args['compania_nombre'] ?? '';
        $this->compania_integrantes = $args['compania_integrantes'] ?? '';
        $this->compania_situacion = $args['compania_situacion'] ?? 1;
    }

    public static function EliminarCompania($id){
        $sql = "DELETE FROM kvsc_compania WHERE compania_id = $id";
        return self::SQL($sql);
    }
}