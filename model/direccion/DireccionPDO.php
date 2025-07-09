<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("DireccionClass.php");
class Daodireccion extends DB
{
    public $direccions = array();
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
        $consulta = 'SELECT * FROM direccion';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $dire = new Direccion(); //creamos un objeto de la entidad situacion
            $dire->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("paisISO", $fila['paisISO']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("provinciaMatricula", $fila['provinciaMatricula']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("codigo_postal", $fila['codigo_postal']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("localidad", $fila['localidad']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("calle", $fila['calle']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("piso", $fila['piso']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("puerta", $fila['puerta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->direccions[] = $dire; //Guardamos ese objeto en el array de objetos dire
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($id)
    {
        $consulta = "SELECT * FROM direccion WHERE id= :id ";
        $param = array();
        $param[":id"] = $id;
        $this->consultaDatos($consulta, $param);
        $dire = new Direccion(); //creamos un objeto de la entidad Direccion
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $dire->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("paisISO", $fila['paisISO']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("provinciaMatricula", $fila['provinciaMatricula']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("codigo_postal", $fila['codigo_postal']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("localidad", $fila['localidad']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("calle", $fila['calle']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("piso", $fila['piso']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("puerta", $fila['puerta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $dire->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $dire;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $dire El objeto a insertar
     * @return void
     */
    public function insertar($dire)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO direccion VALUES (:id, :paisISO, :provinciaMatricula, :codigo_postal, :localidad, :calle, :numero, :piso, :puerta, :usuario_id ) ";
        $param = array();
        $param[":id"] = $dire->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":paisISO"] = $dire->__get("paisISO"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":provinciaMatricula"] = $dire->__get("provinciaMatricula"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":codigo_postal"] = $dire->__get("codigo_postal"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":localidad"] = $dire->__get("localidad"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":calle"] = $dire->__get("calle"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":numero"] = $dire->__get("numero"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":piso"] = $dire->__get("piso"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":puerta"] = $dire->__get("puerta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":usuario_id"] = $dire->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Direccion dire El objeto a actualizar;
     * @return void;
     */
    public function actualizar($dire)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE direccion SET paisISO= :paisISO, provinciaMatricula= :provinciaMatricula, codigo_postal= :codigo_postal, localidad= :localidad, calle= :calle, numero= :numero, piso= :piso, puerta= :puerta, usuario_id= :usuario_id WHERE id= :id";
        $param = array();
        $param[":id"] = $dire->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":paisISO"] = $dire->__get("paisISO"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":provinciaMatricula"] = $dire->__get("provinciaMatricula"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":codigo_postal"] = $dire->__get("codigo_postal"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":localidad"] = $dire->__get("localidad"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":calle"] = $dire->__get("calle"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":numero"] = $dire->__get("numero"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":piso"] = $dire->__get("piso"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":puerta"] = $dire->__get("puerta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":usuario_id"] = $dire->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($id)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM direccion WHERE id= :id";
        $param = array();
        $param[":id"] = $id;
        $this->consultaSimple($consulta, $param);
    }

        public function borrarPorIdUsuario($usuario_id)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM direccion WHERE usuario_id= :usuario_id";
        $param = array();
        $param[":usuario_id"] = $usuario_id;
        $this->consultaSimple($consulta, $param);
    }
}
