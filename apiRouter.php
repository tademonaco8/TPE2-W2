<?php
require_once './libs/router.php';
require_once './app/controllers/apiController.php';
// crea el router
$router = new Router();

//tabla de ruteo
$router->addRoute('lighters', 'GET', 'lightersController', 'ShowLighters');
// $router->addRoute('lighters/:CATEGORY', 'GET', 'lightersController', 'ShowLighters');
$router->addRoute('lighters/:ID', 'GET', 'lightersController', 'GetLighter');
$router->addRoute('lighters/:ID', 'DELETE', 'lightersController', 'DeleteLighter');
$router->addRoute('lighters', 'POST', 'lightersController', 'InsertLighter'); 
$router->addRoute('lighters/:ID', 'PUT', 'lightersController', 'UpdateLighter');

$router->addRoute("auth/token", 'GET', 'AuthApiController', 'getToken');


// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
?>