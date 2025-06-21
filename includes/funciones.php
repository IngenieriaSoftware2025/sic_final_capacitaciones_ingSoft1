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
        header('Location: /sic_final_capacitaciones_ingSoft1/login');
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

function verificarLogin() {
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /' . $_ENV['APP_NAME'] . '/login');
        exit;
    }
}

function obtenerRolUsuario() {
    session_start();
    
    if (!isset($_SESSION['usuario_id'])) {
        return 'Sin sesión';
    }
    
    $usuario_id = $_SESSION['usuario_id'];
    
    try {
        $sql = "SELECT p.permiso_nombre
                FROM kvsc_asig_permisos ap
                INNER JOIN kvsc_permiso p ON p.permiso_id = ap.asignacion_permiso_id
                WHERE ap.asignacion_usuario_id = $usuario_id
                    AND ap.asignacion_situacion = 1
                    AND p.permiso_situacion = 1";
  
        $permisos = \Model\ActiveRecord::fetchArray($sql);
        
        foreach ($permisos as $permiso) {
            if (strpos($permiso['permiso_nombre'], 'Administrador') !== false) {
                return 'Administrador';
            }
            if (strpos($permiso['permiso_nombre'], 'Oficinista') !== false) {
                return 'Oficinista';
            }
            if (strpos($permiso['permiso_nombre'], 'G3') !== false) {
                return 'G3';
            }
        }
        
        return 'Sin permisos';
        
    } catch (Exception $e) {
        return 'Error';
    }
}

function verificarPermisos($modulo) {
    verificarLogin(); 
    
    $rol = obtenerRolUsuario();
  
    $permisos = [
            'Administrador' => [
                'registro', 'aplicacion', 'permisos', 'asignacion', 
                'instructor', 'compania', 'capacitacion', 'horario', 
                'estadisticas', 'mapas', 'auditoria'
            ],
            'Oficinista' => [
                'compania', 'instructor', 'registro'            
            ],
            'G3' => [
                'horario', 'capacitacion'
            ]
    ];
    
 
    if (!isset($permisos[$rol]) || !in_array($modulo, $permisos[$rol])) {
        header('Location: /' . $_ENV['APP_NAME'] . '/sin-permisos');
        exit;
    }
    
    return true;

}

// function IsRegAct () {
  //  $insert = INSERT  INTO AUD  VALUE (nombre, mensaje,fecha, rita) value

//}

