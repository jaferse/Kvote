<?php

//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("ComentarioClass.php");
class Daocomentario extends DB
{
public $comentarios = array();
/**
* Constructor de la clase. Llama al constructor de la clase DB.
* @param string $base nombre de la base de datos
*/
function __construct($base)
{parent::__construct($base); //Llama al constructor de la clase DB
}
public function listar()
{
$consulta = 'SELECT * FROM comentario';
$this->consultaDatos($consulta);
foreach ($this->filas as $fila) {
$come = new Comentario(); //creamos un objeto de la entidad situacion
$come->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("producto_isbn_13", $fila['producto_isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("comentario", $fila['comentario']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("fecha", $fila['fecha']); //Le asignamos a las propiedades del objetos los campos de esa fila
$this->comentarios[] = $come; //Guardamos ese objeto en el array de objetos come
}
}
/**
* Obtiene una situacion de la base de datos por su Id.
*
* @param int $Id El id de la situacion a obtener.
* @return Situacion El objeto Situacion correspondiente al Id proporcionado
* Si no se encuentra, se devuelve un objeto Situacion vacío.
*/
public function obtener($id )
{
$consulta = "SELECT * FROM comentario WHERE id= :id ";
$param = array();
$param[":id"] = $id;
$this->consultaDatos($consulta, $param);
$come = new Comentario(); //creamos un objeto de la entidad Comentario
if (count($this->filas) == 1) {
$fila = $this->filas[0];
$come->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("producto_isbn_13", $fila['producto_isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("comentario", $fila['comentario']); //Le asignamos a las propiedades del objetos los campos de esa fila
$come->__set("fecha", $fila['fecha']); //Le asignamos a las propiedades del objetos los campos de esa fila
}
return $come;
}
/**
* Inserta una situacion en la base de datos
* @param Situacion $come El objeto a insertar
* @return void
*/
public function insertar($come)
{ //Se introduce un objeto por parametro que se insertará
$consulta = "INSERT INTO comentario VALUES (:id, :usuario_id, :producto_isbn_13, :comentario, :fecha ) ";
$param = array();
$param[":id"] =$come->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":usuario_id"] =$come->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":producto_isbn_13"] =$come->__get("producto_isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":comentario"] =$come->__get("comentario"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":fecha"] =$come->__get("fecha"); //Le asignamos a las propiedades del objetos los campos de esa fila
$this->consultaSimple($consulta, $param);
}
/**;
* Actualiza una situacion en la base de datos;
* @param Comentario come El objeto a actualizar;
* @return void;
*/
public function actualizar($come)
{ //Se introduce un objeto por parametro que se insertará
$consulta = " UPDATE comentario SET usuario_id= :usuario_id, producto_isbn_13= :producto_isbn_13, comentario= :comentario, fecha= :fecha WHERE id= :id";
$param = array();
$param[":id"] =$come->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":usuario_id"] =$come->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":producto_isbn_13"] =$come->__get("producto_isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":comentario"] =$come->__get("comentario"); //Le asignamos a las propiedades del objetos los campos de esa fila
$param[":fecha"] =$come->__get("fecha"); //Le asignamos a las propiedades del objetos los campos de esa fila
$this->consultaSimple($consulta, $param);
}
/**
* Borra una situacion en la base de datos
* @param int El id de la situacion a borrar
* @return void
*/
public function borrar($id )
{ //Se introduce un objeto por parametro que se insertará
$consulta = " DELETE FROM comentario WHERE id= :id";
$param = array();
$param[":id"] = $id;
$this->consultaSimple($consulta, $param);
}
}