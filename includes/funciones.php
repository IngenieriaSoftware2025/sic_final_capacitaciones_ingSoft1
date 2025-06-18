<?php

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() {
    session_start();
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}
function isAuthApi() {
    getHeadersApi();
    session_start();
    if(!isset($_SESSION['auth_user'])) {
        echo json_encode([    
            "mensaje" => "No esta autenticado",

            "codigo" => 4,
        ]);
        exit;
    }
}

function isNotAuth(){
    session_start();
    if(isset($_SESSION['auth'])) {
        header('Location: /auth/');
    }
}


function hasPermission(array $permisos){

    $comprobaciones = [];
    foreach ($permisos as $permiso) {

        $comprobaciones[] = !isset($_SESSION[$permiso]) ? false : true;
      
    }

    if(array_search(true, $comprobaciones) !== false){}else{
        header('Location: /');
    }
}

function hasPermissionApi(array $permisos){
    getHeadersApi();
    $comprobaciones = [];
    foreach ($permisos as $permiso) {

        $comprobaciones[] = !isset($_SESSION[$permiso]) ? false : true;
      
    }

    if(array_search(true, $comprobaciones) !== false){}else{
        echo json_encode([     
            "mensaje" => "No tiene permisos",

            "codigo" => 4,
        ]);
        exit;
    }
}

function getHeadersApi(){
    return header("Content-type:application/json; charset=utf-8");
}

function asset($ruta){
    return "/". $_ENV['APP_NAME']."/public/" . $ruta;
}

function verificarPermisos($modulo) {
    session_start();
    
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /login');
        exit;
    }
    
    $usuario_id = $_SESSION['usuario_id'];
    
    try {
        $sql = "SELECT COUNT(*) as es_admin
                FROM kvsc_asig_permisos ap
                INNER JOIN kvsc_permiso p ON p.permiso_id = ap.asignacion_permiso_id
                WHERE ap.asignacion_usuario_id = ?
                    AND p.permiso_nombre LIKE '%Administrador%'
                    AND ap.asignacion_situacion = 1
                    AND p.permiso_situacion = 1";
        
        $resultado = \Model\ActiveRecord::fetchFirst($sql, [$usuario_id]);
        
        if ($resultado['es_admin'] > 0) {
            return true; 
        }
        
        $permisos_modulo = [
            'instructor' => ['%Instructores%'],
            'horario' => ['%Horarios%'],
            'compania' => ['%Compañías%'],
            'capacitacion' => ['%Horarios%'], 
            'estadisticas' => ['%Instructores%', '%Horarios%', '%Compañías%'], 
            'mapas' => ['%Instructores%', '%Horarios%', '%Compañías%']
        ];
        
        if (!isset($permisos_modulo[$modulo])) {
            header('Location: /sin-permisos');
            exit;
        }
        
        foreach ($permisos_modulo[$modulo] as $permiso_requerido) {
            $sql = "SELECT COUNT(*) as tiene_permiso
                    FROM kvsc_asig_permisos ap
                    INNER JOIN kvsc_permiso p ON p.permiso_id = ap.asignacion_permiso_id
                    WHERE ap.asignacion_usuario_id = ?
                        AND p.permiso_nombre LIKE ?
                        AND ap.asignacion_situacion = 1
                        AND p.permiso_situacion = 1";
            
            $resultado = \Model\ActiveRecord::fetchFirst($sql, [$usuario_id, $permiso_requerido]);
            
            if ($resultado['tiene_permiso'] > 0) {
                return true;
            }
        }
        
        header('Location: /sin-permisos');
        exit;
        
    } catch (Exception $e) {
        header('Location: /sin-permisos');
        exit;
    }
}
