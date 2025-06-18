<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Actividades;
use Model\Rutas;

class RutasController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        session_start();
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'ADMIN') {
            header('Location: /sic_final_capacitaciones_ingSoft1/inicio');
            exit;
        }
        
        $router->render('rutas/index', []);
    }

    public static function registrarRutaActividad($modulo, $accion, $descripcion, $ruta = '')
    {
        try {
            session_start();
            if(isset($_SESSION['usuario_id'])) {
                $ruta_actividad = new Rutas([
                    'ruta_usuario_id' => $_SESSION['usuario_id'],
                    'ruta_usuario_nombre' => $_SESSION['user'],
                    'ruta_modulo' => $modulo,
                    'ruta_accion' => $accion,
                    'ruta_descripcion' => $descripcion,
                    'ruta_ip' => $_SERVER['REMOTE_ADDR'] ?? 'No disponible',
                    'ruta_ruta' => $ruta,
                    'ruta_situacion' => 1
                ]);
                $ruta_actividad->crear();
            }
        } catch (Exception $e) {
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
            $usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : null;
            $modulo = isset($_GET['modulo']) ? $_GET['modulo'] : null;
            $accion = isset($_GET['accion']) ? $_GET['accion'] : null;

            $condiciones = ["ruta_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "ruta_fecha_creacion >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "ruta_fecha_creacion <= '{$fecha_fin}'";
            }

            if ($usuario_id) {
                $condiciones[] = "ruta_usuario_id = {$usuario_id}";
            }

            if ($modulo) {
                $condiciones[] = "ruta_modulo = '{$modulo}'";
            }

            if ($accion) {
                $condiciones[] = "ruta_accion = '{$accion}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT * FROM rutas_actividades WHERE $where ORDER BY ruta_fecha_creacion DESC, ruta_id DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Actividades obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las actividades',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarUsuariosAPI()
    {
        try {
            $sql = "SELECT DISTINCT ruta_usuario_id, ruta_usuario_nombre 
                    FROM rutas_actividades 
                    WHERE ruta_situacion = 1
                    ORDER BY ruta_usuario_nombre";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuarios obtenidos correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los usuarios',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

}