<?php
//Configuración de las variables globales
require_once("config/global.php");

//Funciones del controlador de front
require_once("core/controllerFront.php");

//Controladores de DDBB


//Si existen controladores y acciones en la URL las cargamos
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
    if (isset($_GET['isbn'])) {
        $dato = $_GET['isbn'];
    } else if (isset($_GET['tipo'])) {
        $dato = $_GET['tipo'];
    } else if (isset($_GET['id'])) {
        $dato = $_GET['id'];
    } else if(isset($_GET['page'])){
        $dato = $_GET['page'];
    } else if(isset($_GET['username'])){
        $dato = $_GET['username'];
    }else if(isset($_GET['parametro'])){
        $dato = $_GET['parametro'];
    }else {
        $dato = null;
    }
    // echo "Existen controladores";
} else {
    //Si no existen cargamos el controlador y la accion por defecto
    // echo "No Existen controladores";
    $controller = CONTROLADOR_DEFECTO;
    $action = ACCION_DEFECTO;
    $dato = null;
}

//Cargamos el controlador
$controllerObj = cargarControlador($controller);
//Lanzamos la accion
lanzarAccion($controllerObj, $action, $dato);
