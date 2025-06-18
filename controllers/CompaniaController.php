<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Compania;

class CompaniaController extends ActiveRecord{
    
    public static function renderizarPagina(Router $router){
        $router->render('compania/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();
    
        $_POST['compania_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['compania_nombre']))));
        
        $cantidad_nombre = strlen($_POST['compania_nombre']);
        
        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la compañía debe tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['compania_integrantes'] = filter_var($_POST['compania_integrantes'], FILTER_SANITIZE_NUMBER_INT);
        if ($_POST['compania_integrantes'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El número de integrantes debe ser mayor a 0'
            ]);
            exit;
        }

        try {
            $compania = new Compania($_POST);
            $resultado = $compania->crear();

            if($resultado['resultado'] == 1){
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Compañía registrada correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error en registrar la compañía',
                    'datos' => $_POST,
                    'compania' => $compania,
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar compañía',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
    
    public static function buscarAPI()
    {
        getHeadersApi();

        try {
            $sql = "SELECT * FROM kvsc_compania where compania_situacion = 1";
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
                'mensaje' => 'Error al obtener las compañías',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['compania_id'];

        $companiaExistente = Compania::find($id);
        if (!$companiaExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La compañía no existe'
            ]);
            return;
        }

        $_POST['compania_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['compania_nombre']))));
        $_POST['compania_integrantes'] = filter_var($_POST['compania_integrantes'], FILTER_SANITIZE_NUMBER_INT);

        if (strlen($_POST['compania_nombre']) < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la compañía debe tener mas de 1 caracteres'
            ]);
            return;
        }

        if ($_POST['compania_integrantes'] < 1) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El número de integrantes debe ser mayor a 0'
            ]);
            return;
        }

        try {
            $datosActualizar = [
                'compania_nombre' => $_POST['compania_nombre'],
                'compania_integrantes' => $_POST['compania_integrantes']
            ];

            $data = Compania::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información de la compañía ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la compañía',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Compania::EliminarCompania($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La compañía ha sido eliminada correctamente'
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