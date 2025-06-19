<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\RegistroController;
use Controllers\LoginController;
use Controllers\InstructorController;
use Controllers\CompaniaController;
use Controllers\CapacitacionController;
use Controllers\HorarioController;
use Controllers\EstadisticaController;
use Controllers\AsignacionController;
use Controllers\AplicacionController;
use Controllers\PermisosController;
use Controllers\MapaController;
use Controllers\AuditoriaController;


$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [LoginController::class,'renderizarPagina']);

// Rutas para Login
$router->get('/login', [LoginController::class,'renderizarPagina']);
$router->get('/loginn', [LoginController::class,'renderizarPag']);
$router->post('/login', [LoginController::class,'login']);
$router->get('/logout', [LoginController::class,'logout']);
$router->get('/inicio', [LoginController::class,'renderInicio']);
$router->get('/sin-permisos', [LoginController::class, 'sinPermisos']);

//Ruta para Registro
$router->get('/registro', [RegistroController::class,'renderizarPagina']);
$router->post('/registro/guardarAPI', [RegistroController::class,'guardarAPI']);
$router->get('/registro/buscarAPI', [RegistroController::class,'buscarAPI']);
$router->get('/registro/eliminarAPI', [RegistroController::class,'eliminarAPI']);
$router->post('/registro/modificarAPI', [RegistroController::class, 'modificarAPI']); 

//Ruta para aplicaciones
$router->get('/aplicacion', [AplicacionController::class, 'renderizarPagina']);
$router->post('/aplicacion/guardarAPI', [AplicacionController::class, 'guardarAPI']);
$router->get('/aplicacion/buscarAPI', [AplicacionController::class, 'buscarAPI']);
$router->post('/aplicacion/modificarAPI', [AplicacionController::class, 'modificarAPI']);
$router->get('/aplicacion/eliminar', [AplicacionController::class, 'EliminarAPI']);

//Ruta para permisos
$router->get('/permisos', [PermisosController::class, 'renderizarPagina']);
$router->post('/permisos/guardarAPI', [PermisosController::class, 'guardarAPI']);
$router->get('/permisos/buscarAPI', [PermisosController::class, 'buscarAPI']);
$router->post('/permisos/modificarAPI', [PermisosController::class, 'modificarAPI']);
$router->get('/permisos/eliminar', [PermisosController::class, 'EliminarAPI']);
$router->get('/permisos/buscarAplicacionesAPI', [PermisosController::class, 'buscarAplicacionesAPI']);
$router->get('/permisos/buscarUsuariosAPI', [PermisosController::class, 'buscarUsuariosAPI']);

//Ruta para asignacion de permisos
$router->get('/asignacion', [AsignacionController::class, 'renderizarPagina']);
$router->post('/asignacion/guardarAPI', [AsignacionController::class, 'guardarAPI']);
$router->get('/asignacion/buscarAPI', [AsignacionController::class, 'buscarAPI']);
$router->post('/asignacion/modificarAPI', [AsignacionController::class, 'modificarAPI']);
$router->get('/asignacion/eliminar', [AsignacionController::class, 'EliminarAPI']);

$router->get('/asignacion/buscarUsuariosAPI', [AsignacionController::class, 'buscarUsuariosAPI']);
$router->get('/asignacion/buscarAplicacionesAPI', [AsignacionController::class, 'buscarAplicacionesAPI']);
$router->get('/asignacion/buscarPermisosAPI', [AsignacionController::class, 'buscarPermisosAPI']);

//Ruta para Instructores
$router->get('/instructor', [InstructorController::class,'renderizarPagina']);
$router->post('/instructor/guardarAPI', [InstructorController::class,'guardarAPI']);
$router->get('/instructor/buscarAPI', [InstructorController::class,'buscarAPI']);
$router->get('/instructor/eliminarAPI', [InstructorController::class,'eliminarAPI']);
$router->post('/instructor/modificarAPI', [InstructorController::class, 'modificarAPI']);

//Ruta para compañia
$router->get('/compania', [CompaniaController::class,'renderizarPagina']);
$router->post('/compania/guardarAPI', [CompaniaController::class,'guardarAPI']);
$router->get('/compania/buscarAPI', [CompaniaController::class,'buscarAPI']);
$router->get('/compania/eliminarAPI', [CompaniaController::class,'eliminarAPI']);
$router->post('/compania/modificarAPI', [CompaniaController::class, 'modificarAPI']);

//Ruta para capacitacion
$router->get('/capacitacion', [CapacitacionController::class,'renderizarPagina']);
$router->post('/capacitacion/guardarAPI', [CapacitacionController::class,'guardarAPI']);
$router->get('/capacitacion/buscarAPI', [CapacitacionController::class,'buscarAPI']);
$router->post('/capacitacion/modificarAPI', [CapacitacionController::class, 'modificarAPI']);
$router->get('/capacitacion/eliminarAPI', [CapacitacionController::class,'eliminarAPI']);

//Ruta para horarios de entrenamiento
$router->get('/horario', [HorarioController::class,'renderizarPagina']);
$router->post('/horario/guardarAPI', [HorarioController::class,'guardarAPI']);
$router->get('/horario/buscarAPI', [HorarioController::class,'buscarAPI']);
$router->get('/horario/eliminarAPI', [HorarioController::class,'eliminarAPI']);
$router->post('/horario/modificarAPI', [HorarioController::class, 'modificarAPI']);
$router->get('/horario/obtenerCapacitacionesAPI', [HorarioController::class,'obtenerCapacitacionesAPI']);
$router->get('/horario/obtenerInstructoresAPI', [HorarioController::class,'obtenerInstructoresAPI']);
$router->get('/horario/obtenerCompaniasAPI', [HorarioController::class,'obtenerCompaniasAPI']);

//Rutas para estadisticas
$router->get('/estadistica', [EstadisticaController::class,'renderizarPagina']);
$router->get('/estadistica/buscarUnidadesAPI', [EstadisticaController::class,'buscarUnidadesAPI']);
$router->get('/estadistica/buscarInstructoresAPI', [EstadisticaController::class,'buscarInstructoresAPI']);

//Rutas para mapas
$router->get('/mapas', [MapaController::class,'renderizarPagina']);

//Rutas para Auditorias
$router->get('/auditoria', [AuditoriaController::class,'renderizarPagina']);
$router->get('/auditoria/buscarHistorialAPI', [AuditoriaController::class,'buscarHistorialAPI']);
$router->get('/auditoria/actividadesPorMesAPI', [AuditoriaController::class,'actividadesPorMesAPI']);
$router->get('/auditoria/usuariosMasActivosAPI', [AuditoriaController::class,'usuariosMasActivosAPI']);
$router->get('/auditoria/rutasMasUsadasAPI', [AuditoriaController::class,'rutasMasUsadasAPI']);
$router->get('/auditoria/estadisticasGeneralesAPI', [AuditoriaController::class,'estadisticasGeneralesAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
