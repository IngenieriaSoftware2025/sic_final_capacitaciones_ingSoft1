<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Controllers\AuditoriaController;
class MapaController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        verificarPermisos('mapas');
        
     isAuth();
        $router->render('mapas/index', []);
    }

}