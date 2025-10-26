<?php
require_once("./controller/IndexController.php");

//FUNCIONES PARA EL CONTROLADOR FRONTAL
//Carga un controlador u otro en funcion de lo que se pase por la URL

/**
 * Carga el controlador que se pasa como parametro o el controlador por defecto
 *
 * @param string $controller
 * @return object
 */
function cargarControlador($controller)
{

    //Pone en mayuscula la primera letra del controlador introducido
    $controlador = ucwords($controller) . 'Controller';
    // Cargamos el controlador
    $strFileController = './controller/' . $controlador . '.php';

    //Si no existe el controlador cargamos el de por defecto por defecto
    if (!is_file($strFileController)) {
        $strFileController = './controller/' . ucwords(CONTROLADOR_DEFECTO) . 'Controller.php';
    }

    //Incluye el fichero
    require_once $strFileController;
    //Creamos una instancia del controlador
    $controllerObj = new $controlador();

    //Devolvemos el controlador
    return $controllerObj;
}


/**
 * Carga una accion de un controlador
 *
 * @param object $controllerObj Instancia del controlador
 * @param string $action Nombre de la accion a cargar
 * @return void
 */
function cargarAccion($controllerObj, $action, $argumento = null)
{
    $accion = $action;
    $controllerObj->$accion($argumento);
}


/**
 * Lanza una accion de un controlador
 *
 * Comprueba si la accion existe en el controlador y en caso de que no exista
 * carga la accion por defecto
 *
 * @param object $controllerObj Instancia del controlador
 * @return void
 */
function lanzarAccion($controllerObj, $accion, $argumento = null)
{
    if (isset($_GET["action"]) && method_exists($controllerObj, $accion)) {
        cargarAccion($controllerObj, $accion, $argumento);
    } else {
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
}
