<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class AuditoriaController extends ActiveRecord{
    
    public static function renderizarPagina(Router $router){
        $router->render('auditoria/index', []);
    }

    public static function registrarActividad($accion, $descripcion) {
        try {
            session_start();
            if(isset($_SESSION['usuario_id'])) {
                $sql_ruta = "SELECT ruta_id FROM kvsc_rutas WHERE ruta_descripcion = ? AND ruta_situacion = 1";
                $ruta_existe = self::fetchFirst($sql_ruta, [$descripcion]);
                
                if (!$ruta_existe) {

                    $sql_crear = "INSERT INTO kvsc_rutas (ruta_app_id, ruta_nombre, ruta_descripcion, ruta_situacion)
                                  VALUES (1, ?, ?, 1)";
                    self::SQL($sql_crear, [$accion, $descripcion]);
                    
                    $ruta_nueva = self::fetchFirst($sql_ruta, [$descripcion]);
                    $ruta_id = $ruta_nueva['ruta_id'];
                } else {
                    $ruta_id = $ruta_existe['ruta_id'];
                }
                
                $sql = "INSERT INTO kvsc_historial_act 
                        (historial_usuario_id, historial_fecha, historial_ruta, historial_ejecucion, historial_status, historial_situacion)
                        VALUES (?, CURRENT, ?, ?, 1, 1)";
                
                self::SQL($sql, [$_SESSION['usuario_id'], $ruta_id, $descripcion]);
            }
        } catch (Exception $e) {
            
        }
    }

    public static function buscarAPI(){
        try {
            $sql = "SELECT 
                h.historial_id,
                h.historial_fecha,
                h.historial_ejecucion,
                u.usuario_nom1 || ' ' || u.usuario_ape1 as usuario_nombre,
                r.ruta_descripcion as accion
                FROM kvsc_historial_act h
                INNER JOIN kvsc_usuario u ON u.usuario_id = h.historial_usuario_id
                INNER JOIN kvsc_rutas r ON r.ruta_id = h.historial_ruta
                WHERE h.historial_situacion = 1
                ORDER BY h.historial_fecha DESC
                LIMIT 100;";
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
                'mensaje' => 'Error al obtener actividades'
            ]);
        }
    }

    public static function usuariosActivosAPI(){
        try {
            $sql = "SELECT 
                u.usuario_nom1 || ' ' || u.usuario_ape1 as usuario,
                COUNT(h.historial_id) as total
                FROM kvsc_historial_act h
                INNER JOIN kvsc_usuario u ON u.usuario_id = h.historial_usuario_id
                WHERE h.historial_situacion = 1
                GROUP BY u.usuario_id, u.usuario_nom1, u.usuario_ape1
                ORDER BY total DESC
                LIMIT 5;";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuarios activos obtenidos',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error'
            ]);
        }
    }
}