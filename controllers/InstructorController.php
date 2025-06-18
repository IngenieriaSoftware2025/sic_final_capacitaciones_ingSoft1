<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Instructor;

class InstructorController extends ActiveRecord{
    
    public static function renderizarPagina(Router $router){
        verificarPermisos('instructor');
        
        $router->render('instructor/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();
    
        $_POST['instructor_nombres'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_nombres']))));
        
        $cantidad_nombres = strlen($_POST['instructor_nombres']);
        
        if ($cantidad_nombres < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los nombres deben tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['instructor_apellidos'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_apellidos']))));
        
        $cantidad_apellidos = strlen($_POST['instructor_apellidos']);
        
        if ($cantidad_apellidos < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los apellidos deben tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['instructor_grado'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_grado']))));
        $cantidad_grado = strlen($_POST['instructor_grado']);
        
        if ($cantidad_grado < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El grado debe tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['instructor_arma'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_arma']))));
        $cantidad_arma = strlen($_POST['instructor_arma']);
        
        if ($cantidad_arma < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El arma debe tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['instructor_telefono'] = filter_var($_POST['instructor_telefono'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['instructor_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El telefono debe de tener 8 numeros'
            ]);
            exit;
        }

        try {
            $instructor = new Instructor($_POST);
            $resultado = $instructor->crear();

            if($resultado['resultado'] == 1){
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Instructor registrado correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error en registrar al instructor',
                    'datos' => $_POST,
                    'instructor' => $instructor,
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar instructor',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function buscarAPI()
    {
        getHeadersApi();

        try {
            $sql = "SELECT * FROM kvsc_instructor where instructor_situacion = 1";
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
                'mensaje' => 'Error al obtener los instructores',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['instructor_id'];

        $instructorExistente = Instructor::find($id);
        if (!$instructorExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El instructor no existe'
            ]);
            return;
        }

        $_POST['instructor_nombres'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_nombres']))));
        $_POST['instructor_apellidos'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_apellidos']))));
        $_POST['instructor_grado'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_grado']))));
        $_POST['instructor_arma'] = ucwords(strtolower(trim(htmlspecialchars($_POST['instructor_arma']))));
        $_POST['instructor_telefono'] = filter_var($_POST['instructor_telefono'], FILTER_SANITIZE_NUMBER_INT);

        if (strlen($_POST['instructor_nombres']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los nombres deben tener mas de 1 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['instructor_apellidos']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los apellidos deben tener mas de 1 caracteres'
            ]);
            return;
        }

        if (strlen($_POST['instructor_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El telefono debe de tener 8 numeros'
            ]);
            return;
        }

        try {
            $datosActualizar = [
                'instructor_nombres' => $_POST['instructor_nombres'],
                'instructor_apellidos' => $_POST['instructor_apellidos'],
                'instructor_grado' => $_POST['instructor_grado'],
                'instructor_arma' => $_POST['instructor_arma'],
                'instructor_telefono' => $_POST['instructor_telefono']
            ];

            $data = Instructor::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del instructor ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el instructor',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Instructor::EliminarInstructor($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El instructor ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al Eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}