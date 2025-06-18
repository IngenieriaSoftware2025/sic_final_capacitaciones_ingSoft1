<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\HorarioEntrenamiento;
use Model\Instructor;
use Model\Compania;
use Model\Usuario;
use MVC\Router;

class EstadisticaController extends ActiveRecord{
    
    public static function renderizarPagina(Router $router){
        $router->render('estadistica/index', []);
    }

    public static function buscarUnidadesAPI(){
        try {
            $sql = "SELECT 
                c.compania_nombre as unidad,
                COUNT(h.horario_id) as total_entrenamientos,
                c.compania_id
                FROM kvsc_horario_entrenamiento h
                INNER JOIN kvsc_compania c ON c.compania_id = h.horario_compania_id
                WHERE h.horario_situacion = 1 
                    AND c.compania_situacion = 1
                GROUP BY c.compania_id, c.compania_nombre
                ORDER BY total_entrenamientos DESC;";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Entrenamientos por unidades obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener entrenamientos por unidades',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function buscarInstructoresAPI(){
        try {
            $sql = "SELECT 
                i.instructor_nombres || ' ' || i.instructor_apellidos as instructor,
                i.instructor_grado,
                COUNT(h.horario_id) as total_catedras,
                i.instructor_id
                FROM kvsc_horario_entrenamiento h
                INNER JOIN kvsc_instructor i ON i.instructor_id = h.horario_instructor_id
                WHERE h.horario_situacion = 1 
                    AND i.instructor_situacion = 1
                GROUP BY i.instructor_id, i.instructor_nombres, i.instructor_apellidos, i.instructor_grado
                ORDER BY total_catedras DESC;";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Cátedras por instructores obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener cátedras por instructores',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}