<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Capacitacion;
use Controllers\AuditoriaController;

class CapacitacionController extends ActiveRecord{
    
    public static function renderizarPagina(Router $router){
        verificarPermisos('capacitacion');
         isAuth();
        $router->render('capacitacion/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();
    
        $_POST['capacitacion_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['capacitacion_nombre']))));
        $_POST['capacitacion_descripcion'] = trim(htmlspecialchars($_POST['capacitacion_descripcion']));
        $_POST['capacitacion_tipo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['capacitacion_tipo']))));
        
        if (strlen($_POST['capacitacion_nombre']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre debe tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        if (strlen($_POST['capacitacion_descripcion']) < 10) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción debe tener al menos 10 caracteres'
            ]);
            exit;
        }
        
        if (strlen($_POST['capacitacion_tipo']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El tipo debe tener mas de 1 caracteres'
            ]);
            exit;
        }

        try {
            $capacitacion = new Capacitacion($_POST);
            $resultado = $capacitacion->crear();

            if($resultado['resultado'] == 1){

                AuditoriaController::registrarActividad("CREAR_CAPACITACION", "Capacitación creada: " . $_POST['capacitacion_nombre']);


                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Capacitación registrada correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al registrar capacitación',
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar capacitación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function buscarAPI()
    {
        getHeadersApi();

        try {
            $sql = "SELECT * FROM kvsc_capacitacion WHERE capacitacion_situacion = 1";
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

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['capacitacion_id'];

        $capacitacionExistente = Capacitacion::find($id);
        if (!$capacitacionExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La capacitación no existe'
            ]);
            return;
        }

        $_POST['capacitacion_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['capacitacion_nombre']))));
        $_POST['capacitacion_descripcion'] = trim(htmlspecialchars($_POST['capacitacion_descripcion']));
        $_POST['capacitacion_tipo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['capacitacion_tipo']))));

        if (strlen($_POST['capacitacion_nombre']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre debe tener mas de 1 caracteres'
            ]);
            return;
        }

        try {
            $datosActualizar = [
                'capacitacion_nombre' => $_POST['capacitacion_nombre'],
                'capacitacion_descripcion' => $_POST['capacitacion_descripcion'],
                'capacitacion_tipo' => $_POST['capacitacion_tipo']
            ];

            $data = Capacitacion::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();
            AuditoriaController::registrarActividad("MODIFICAR_CAPACITACION", "Capacitación modificada ID: " . $_POST['capacitacion_id']);


            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Capacitación modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar capacitación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Capacitacion::EliminarCapacitacion($id);
            AuditoriaController::registrarActividad("ELIMINAR_CAPACITACION", "Capacitación eliminada ID: " . $_GET['id']);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Capacitación eliminada correctamente'
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