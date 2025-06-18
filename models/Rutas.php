<?php

namespace Model;

use Model\ActiveRecord;

class Rutas extends ActiveRecord {
    
    public static $tabla = 'kvsc_rutas';
    public static $idTabla = 'ruta_id';
    public static $columnasDB = 
    [
        'ruta_id',
        'ruta_app_id',
        'ruta_nombre',
        'ruta_descripcion',
        'ruta_situacion',
    ];

    public $ruta_id;
    public $ruta_app_id;
    public $ruta_nombre;
    public $ruta_descripcion;
    public $ruta_situacion;


public function __construct($ruta = [])
{
    $this->ruta_id = $ruta['ruta_id'] ?? null;
    $this->ruta_app_id = $ruta['ruta_app_id'] ?? 0;
    $this->ruta_nombre = $ruta ['ruta_nombre'] ?? '';
    $this->ruta_descripcion = $ruta ['ruta_descripcion'] ?? '';
    $this->ruta_situacion = $ruta['ruta_situacion'] ?? 1;   
}

public static function EliminarRuta($id){
    $sql = "UPDATE kvsc_rutas SET ruta_situacion = 0 WHERE ruta_id = $id";
    return self::SQL($sql);
}
}