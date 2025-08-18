<?php
require_once("./core/DBClass.php");
require_once("ProvinciaClass.php");
class Daoprovincia extends DB
{
    public $provincias = array();
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
        $consulta = 'SELECT * FROM provincia';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $prov = new Provincia(); //creamos un objeto de la entidad situacion
            $prov->__set("codigo_matricula", $fila['codigo_matricula']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prov->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prov->__set("codigo_pais", $fila['codigo_pais']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->provincias[] = $prov; //Guardamos ese objeto en el array de objetos prov
        }
    }
    public function listarPorPais($pais)
    {
        $consulta = 'SELECT * FROM provincia  WHERE codigo_pais= :codigo_pais';
        // $consulta .= " WHERE codigo_pais= :codigo_pais";
        $param = array();
        $param[":codigo_pais"] = $pais;
        $this->consultaDatos($consulta, $param);
        foreach ($this->filas as $fila) {
            $prov = new Provincia(); //creamos un objeto de la entidad situacion
            $prov->__set("codigo_matricula", $fila['codigo_matricula']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prov->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prov->__set("codigo_pais", $fila['codigo_pais']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->provincias[] = $prov; //Guardamos ese objeto en el array de objetos prov
        }
        return $this->provincias;
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($codigo_matricula, $codigo_pais)
    {
        $consulta = "SELECT * FROM provincia WHERE codigo_matricula= :codigo_matricula AND codigo_pais= :codigo_pais ";
        $param = array();
        $param[":codigo_matricula"] = $codigo_matricula;
        $param[":codigo_pais"] = $codigo_pais;
        $this->consultaDatos($consulta, $param);
        $prov = new Provincia(); //creamos un objeto de la entidad Provincia
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $prov->__set("codigo_matricula", $fila['codigo_matricula']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prov->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prov->__set("codigo_pais", $fila['codigo_pais']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $prov;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $prov El objeto a insertar
     * @return void
     */
    public function insertar($prov)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO provincia VALUES (:codigo_matricula, :nombre, :codigo_pais ) ";
        $param = array();
        $param[":codigo_matricula"] = $prov->__get("codigo_matricula"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $prov->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":codigo_pais"] = $prov->__get("codigo_pais"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Provincia prov El objeto a actualizar;
     * @return void;
     */
    public function actualizar($prov)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE provincia SET nombre= :nombre, WHERE codigo_matricula= :codigo_matricula AND codigo_pais= :codigo_pais";
        $param = array();
        $param[":codigo_matricula"] = $prov->__get("codigo_matricula"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $prov->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":codigo_pais"] = $prov->__get("codigo_pais"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($codigo_matricula, $codigo_pais)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM provincia WHERE codigo_matricula= :codigo_matricula AND codigo_pais= :codigo_pais";
        $param = array();
        $param[":codigo_matricula"] = $codigo_matricula;
        $param[":codigo_pais"] = $codigo_pais;
        $this->consultaSimple($consulta, $param);
    }
}
