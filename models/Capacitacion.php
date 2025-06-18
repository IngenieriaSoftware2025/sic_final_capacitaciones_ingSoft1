<?php

namespace Model;

class Capacitacion extends ActiveRecord {

    public static $tabla = 'kvsc_capacitacion';
    public static $columnasDB = [
        'capacitacion_nombre',
        'capacitacion_descripcion',
        'capacitacion_tipo',
        'capacitacion_situacion'
    ];

    public static $idTabla = 'capacitacion_id';
    public $capacitacion_id;
    public $capacitacion_nombre;
    public $capacitacion_descripcion;
    public $capacitacion_tipo;
    public $capacitacion_situacion;

    public function __construct($args = []){
        $this->capacitacion_id = $args['capacitacion_id'] ?? null;
        $this->capacitacion_nombre = $args['capacitacion_nombre'] ?? '';
        $this->capacitacion_descripcion = $args['capacitacion_descripcion'] ?? '';
        $this->capacitacion_tipo = $args['capacitacion_tipo'] ?? '';
        $this->capacitacion_situacion = $args['capacitacion_situacion'] ?? 1;
    }

    public static function EliminarCapacitacion($id){
        $sql = "DELETE FROM kvsc_capacitacion WHERE capacitacion_id = $id";
        return self::SQL($sql);
    }
}