<?php

namespace Model;

class HorarioEntrenamiento extends ActiveRecord {

    public static $tabla = 'kvsc_horario_entrenamiento';
    public static $columnasDB = [
        'horario_capacitacion_id',
        'horario_instructor_id',
        'horario_compania_id',
        'horario_fecha_inicio',
        'horario_fecha_fin',
        'horario_hora_inicio',
        'horario_hora_fin',
        'horario_ubicacion',
        'horario_estado',
        'horario_usuario_asigno',
        'horario_fecha_creacion',
        'horario_observaciones',
        'horario_situacion'
    ];

    public static $idTabla = 'horario_id';
    public $horario_id;
    public $horario_capacitacion_id;
    public $horario_instructor_id;
    public $horario_compania_id;
    public $horario_fecha_inicio;
    public $horario_fecha_fin;
    public $horario_hora_inicio;
    public $horario_hora_fin;
    public $horario_ubicacion;
    public $horario_estado;
    public $horario_usuario_asigno;
    public $horario_fecha_creacion;
    public $horario_observaciones;
    public $horario_situacion;

    public function __construct($args = []){
        $this->horario_id = $args['horario_id'] ?? null;
        $this->horario_capacitacion_id = $args['horario_capacitacion_id'] ?? '';
        $this->horario_instructor_id = $args['horario_instructor_id'] ?? '';
        $this->horario_compania_id = $args['horario_compania_id'] ?? '';
        $this->horario_fecha_inicio = $args['horario_fecha_inicio'] ?? '';
        $this->horario_fecha_fin = $args['horario_fecha_fin'] ?? '';
        $this->horario_hora_inicio = $args['horario_hora_inicio'] ?? '';
        $this->horario_hora_fin = $args['horario_hora_fin'] ?? '';
        $this->horario_ubicacion = $args['horario_ubicacion'] ?? '';
        $this->horario_estado = $args['horario_estado'] ?? 'PROGRAMADO';
        $this->horario_usuario_asigno = $args['horario_usuario_asigno'] ?? '';
        $this->horario_fecha_creacion = $args['horario_fecha_creacion'] ?? date('Y-m-d');
        $this->horario_observaciones = $args['horario_observaciones'] ?? '';
        $this->horario_situacion = $args['horario_situacion'] ?? 1;
    }

    public static function EliminarHorario($id){
        $sql = "DELETE FROM kvsc_horario_entrenamiento WHERE horario_id = $id";
        return self::SQL($sql);
    }
}