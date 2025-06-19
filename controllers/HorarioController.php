<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\HorarioEntrenamiento;

class HorarioController extends ActiveRecord{
    
    public static function renderizarPagina(Router $router){
      verificarPermisos('horario');
        
        $router->render('horario/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();
    
        $_POST['horario_capacitacion_id'] = filter_var($_POST['horario_capacitacion_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['horario_instructor_id'] = filter_var($_POST['horario_instructor_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['horario_compania_id'] = filter_var($_POST['horario_compania_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['horario_ubicacion'] = trim(htmlspecialchars($_POST['horario_ubicacion']));
        $_POST['horario_usuario_asigno'] = 1; 
        
        if ($_POST['horario_capacitacion_id'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una capacitación'
            ]);
            exit;
        }
        
        if ($_POST['horario_instructor_id'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un instructor'
            ]);
            exit;
        }
        
        if ($_POST['horario_compania_id'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una compañía'
            ]);
            exit;
        }
        
        if (strlen($_POST['horario_ubicacion']) < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La ubicación debe tener al menos 5 caracteres'
            ]);
            exit;
        }
        
        if ($_POST['horario_fecha_inicio'] > $_POST['horario_fecha_fin']) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La fecha de inicio no puede ser mayor a la fecha de fin'
            ]);
            exit;
        }

        try {
            $horario = new HorarioEntrenamiento($_POST);
            $resultado = $horario->crear();

            if($resultado['resultado'] == 1){
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Horario registrado correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al registrar horario',
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar horario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function buscarAPI()
    {
        getHeadersApi();

        try {
            $sql = "SELECT h.*, c.capacitacion_nombre, i.instructor_nombres, i.instructor_apellidos, comp.compania_nombre 
                    FROM kvsc_horario_entrenamiento h
                    INNER JOIN kvsc_capacitacion c ON h.horario_capacitacion_id = c.capacitacion_id
                    INNER JOIN kvsc_instructor i ON h.horario_instructor_id = i.instructor_id
                    INNER JOIN kvsc_compania comp ON h.horario_compania_id = comp.compania_id
                    WHERE h.horario_situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Horarios obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener horarios',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function obtenerCapacitacionesAPI()
    {
        getHeadersApi();

        try {
            $sql = "SELECT capacitacion_id, capacitacion_nombre FROM kvsc_capacitacion WHERE capacitacion_situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Capacitaciones obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener capacitaciones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function obtenerInstructoresAPI()
    {
        getHeadersApi();

        try {
            $sql = "SELECT instructor_id, instructor_nombres, instructor_apellidos FROM kvsc_instructor WHERE instructor_situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Instructores obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener instructores',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function obtenerCompaniasAPI()
    {
        getHeadersApi();

        try {
            $sql = "SELECT compania_id, compania_nombre FROM kvsc_compania WHERE compania_situacion = 1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Compañías obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener compañías',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['horario_id'];

        $horarioExistente = HorarioEntrenamiento::find($id);
        if (!$horarioExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El horario no existe'
            ]);
            return;
        }

        $_POST['horario_capacitacion_id'] = filter_var($_POST['horario_capacitacion_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['horario_instructor_id'] = filter_var($_POST['horario_instructor_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['horario_compania_id'] = filter_var($_POST['horario_compania_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['horario_ubicacion'] = trim(htmlspecialchars($_POST['horario_ubicacion']));

        if ($_POST['horario_capacitacion_id'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una capacitación'
            ]);
            return;
        }

        if (strlen($_POST['horario_ubicacion']) < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La ubicación debe tener al menos 5 caracteres'
            ]);
            return;
        }

        try {
            $datosActualizar = [
                'horario_capacitacion_id' => $_POST['horario_capacitacion_id'],
                'horario_instructor_id' => $_POST['horario_instructor_id'],
                'horario_compania_id' => $_POST['horario_compania_id'],
                'horario_fecha_inicio' => $_POST['horario_fecha_inicio'],
                'horario_fecha_fin' => $_POST['horario_fecha_fin'],
                'horario_hora_inicio' => $_POST['horario_hora_inicio'],
                'horario_hora_fin' => $_POST['horario_hora_fin'],
                'horario_ubicacion' => $_POST['horario_ubicacion'],
                'horario_estado' => $_POST['horario_estado'],
                'horario_observaciones' => trim(htmlspecialchars($_POST['horario_observaciones']))
            ];

            $data = HorarioEntrenamiento::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Horario modificado exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar horario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = HorarioEntrenamiento::EliminarHorario($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Horario eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}