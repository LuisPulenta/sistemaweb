<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\UsuarioController;
use Controllers\AdminController;
use MVC\Router;

$router = new Router();

//Iniciar Sesión
$router->get('/',[LoginController::class, 'login']);
$router->post('/',[LoginController::class, 'login']);
$router->post('/logout',[LoginController::class,'logout']);

//Recuperar Password
$router->get('/olvide',[LoginController::class, 'olvide']);
$router->post('/olvide',[LoginController::class, 'olvide']);
$router->get('/recuperar',[LoginController::class, 'recuperar']);
$router->post('/recuperar',[LoginController::class, 'recuperar']);

//Crear Cuenta
$router->get('/crear',[LoginController::class, 'crear']);
$router->post('/crear',[LoginController::class, 'crear']);

//Confirmar Cuenta
$router->get('/confirmar',[LoginController::class, 'confirmar']);
$router->get('/mensaje',[LoginController::class, 'mensaje']);

//************************
//***** AREA PRIVADA *****
//************************

//Confirmar Cuenta
$router->get('/admin/dashboard', [AdminController::class, 'index']);
$router->get('/usuario/dashboard', [UsuarioController::class, 'index']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();