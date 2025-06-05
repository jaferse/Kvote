<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("LocalidadClass.php");
class Daolocalidad extends DB
{
    public $localidads = array();
    /**
     * Constructor de la clase. Llama al constructor de la clase DB.
     * @param string $base nombre de la base de datos
     */
    function __construct($base)
    {
        parent::__construct($base); //Llama al constructor de la clase DB
    }
    public function listar()
    {
        $consulta = 'SELECT * FROM localidad';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $loca = new Localidad(); //creamos un objeto de la entidad situacion
            $loca->__set("codigo", $fila['codigo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $loca->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $loca->__set("codigo_provincia", $fila['codigo_provincia']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->localidads[] = $loca; //Guardamos ese objeto en el array de objetos loca
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($codigo)
    {
        $consulta = "SELECT * FROM localidad WHERE codigo= :codigo ";
        $param = array();
        $param[":codigo"] = $codigo;
        $this->consultaDatos($consulta, $param);
        $loca = new Localidad(); //creamos un objeto de la entidad Localidad
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $loca->__set("codigo", $fila['codigo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $loca->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $loca->__set("codigo_provincia", $fila['codigo_provincia']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $loca;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $loca El objeto a insertar
     * @return void
     */
    public function insertar($loca)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO localidad VALUES (:codigo, :nombre, :codigo_provincia ) ";
        $param = array();
        $param[":codigo"] = $loca->__get("codigo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $loca->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":codigo_provincia"] = $loca->__get("codigo_provincia"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Localidad loca El objeto a actualizar;
     * @return void;
     */
    public function actualizar($loca)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE localidad SET nombre= :nombre, codigo_provincia= :codigo_provincia WHERE codigo= :codigo";
        $param = array();
        $param[":codigo"] = $loca->__get("codigo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $loca->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":codigo_provincia"] = $loca->__get("codigo_provincia"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($codigo)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM localidad WHERE codigo= :codigo";
        $param = array();
        $param[":codigo"] = $codigo;
        $this->consultaSimple($consulta, $param);
    }
}
