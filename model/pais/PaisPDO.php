<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("PaisClass.php");
class Daopais extends DB
{
    public $paiss = array();
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
        $consulta = 'SELECT * FROM pais';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $pais = new Pais(); //creamos un objeto de la entidad situacion
            $pais->__set("codigo_iso", $fila['codigo_iso']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $pais->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->paiss[] = $pais; //Guardamos ese objeto en el array de objetos pais
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($codigo_iso)
    {
        $consulta = "SELECT * FROM pais WHERE codigo_iso= :codigo_iso ";
        $param = array();
        $param[":codigo_iso"] = $codigo_iso;
        $this->consultaDatos($consulta, $param);
        $pais = new Pais(); //creamos un objeto de la entidad Pais
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $pais->__set("codigo_iso", $fila['codigo_iso']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $pais->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $pais;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $pais El objeto a insertar
     * @return void
     */
    public function insertar($pais)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO pais VALUES (:codigo_iso, :nombre ) ";
        $param = array();
        $param[":codigo_iso"] = $pais->__get("codigo_iso"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $pais->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Pais pais El objeto a actualizar;
     * @return void;
     */
    public function actualizar($pais)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE pais SET nombre= :nombre WHERE codigo_iso= :codigo_iso";
        $param = array();
        $param[":codigo_iso"] = $pais->__get("codigo_iso"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $pais->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($codigo_iso)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM pais WHERE codigo_iso= :codigo_iso";
        $param = array();
        $param[":codigo_iso"] = $codigo_iso;
        $this->consultaSimple($consulta, $param);
    }


}
