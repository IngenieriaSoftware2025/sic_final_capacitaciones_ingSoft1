<?php

namespace Model;

use Model\ActiveRecord;

class AsignacionPermisos extends ActiveRecord {

    public static $tabla = 'kvsc_asig_permisos';
    public static $idTabla = 'asignacion_id';
    public static $columnasDB = [
        'asignacion_usuario_id',
        'asignacion_app_id',
        'asignacion_permiso_id',
        'asignacion_fecha',
        'asignacion_quitar_fechapermiso',
        'asignacion_usuario_asigno',
        'asignacion_motivo',
        'asignacion_situacion'
    ];

    public $asignacion_id;
    public $asignacion_usuario_id;
    public $asignacion_app_id;
    public $asignacion_permiso_id;
    public $asignacion_fecha;
    public $asignacion_quitar_fechapermiso;
    public $asignacion_usuario_asigno;
    public $asignacion_motivo;
    public $asignacion_situacion;

    public function __construct($args = []){
        $this->asignacion_id = $args['asignacion_id'] ?? null;
        $this->asignacion_usuario_id = $args['asignacion_usuario_id'] ?? 0;
        $this->asignacion_app_id = $args['asignacion_app_id'] ?? 0;
        $this->asignacion_permiso_id = $args['asignacion_permiso_id'] ?? 0;
        $this->asignacion_fecha = $args['asignacion_fecha'] ?? date('Y-m-d H:i:s');
       $this->asignacion_quitar_fechapermiso = $args['asignacion_quitar_fechapermiso'] ?? date('Y-m-d H:i:s');
        $this->asignacion_usuario_asigno = $args['asignacion_usuario_asigno'] ?? 0;
        $this->asignacion_motivo = $args['asignacion_motivo'] ?? '';
        $this->asignacion_situacion = $args['asignacion_situacion'] ?? 1;
    }

    public static function EliminarAsignacion($id){
        $sql = "UPDATE asig_permisos SET asignacion_situacion = 0 WHERE asignacion_id = $id";
        return self::SQL($sql);
    }
}