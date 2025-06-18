<?php

namespace Model;

class Instructor extends ActiveRecord {

    public static $tabla = 'kvsc_instructor';
    public static $columnasDB = [
        'instructor_nombres',
        'instructor_apellidos',
        'instructor_grado',
        'instructor_arma',
        'instructor_telefono',
        'instructor_situacion'
    ];

    public static $idTabla = 'instructor_id';
    public $instructor_id;
    public $instructor_nombres;
    public $instructor_apellidos;
    public $instructor_grado;
    public $instructor_arma;
    public $instructor_telefono;
    public $instructor_situacion;

    public function __construct($args = []){
        $this->instructor_id = $args['instructor_id'] ?? null;
        $this->instructor_nombres = $args['instructor_nombres'] ?? '';
        $this->instructor_apellidos = $args['instructor_apellidos'] ?? '';
        $this->instructor_grado = $args['instructor_grado'] ?? '';
        $this->instructor_arma = $args['instructor_arma'] ?? '';
        $this->instructor_telefono = $args['instructor_telefono'] ?? '';
        $this->instructor_situacion = $args['instructor_situacion'] ?? 1;
    }

    public static function EliminarInstructor($id){
        $sql = "DELETE FROM kvsc_instructor WHERE instructor_id = $id";
        return self::SQL($sql);
    }
}