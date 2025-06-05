<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("CompraClass.php");
class Daocompra extends DB
{
    public $compras = array();
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
        $consulta = 'SELECT * FROM compra';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $comp = new Compra(); //creamos un objeto de la entidad situacion
            $comp->__set("idCompra", $fila['idCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("idUsuario", $fila['idUsuario']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("fechaCompra", $fila['fechaCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("totalCompra", $fila['totalCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->compras[] = $comp; //Guardamos ese objeto en el array de objetos comp
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($idCompra)
    {
        $consulta = "SELECT * FROM compra WHERE idCompra= :idCompra ";
        $param = array();
        $param[":idCompra"] = $idCompra;
        $this->consultaDatos($consulta, $param);
        $comp = new Compra(); //creamos un objeto de la entidad Compra
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $comp->__set("idCompra", $fila['idCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("idUsuario", $fila['idUsuario']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("fechaCompra", $fila['fechaCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("totalCompra", $fila['totalCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $comp;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $comp El objeto a insertar
     * @return void
     */
    public function insertar($comp)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO compra (idCompra, idUsuario, totalCompra) VALUES (:idCompra, :idUsuario,  :totalCompra ) ";
        $param = array();
        $param[":idCompra"] = $comp->__get("idCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":idUsuario"] = $comp->__get("idUsuario"); //Le asignamos a las propiedades del objetos los campos de esa fila
        // $param[":fechaCompra"] = $comp->__get("fechaCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":totalCompra"] = $comp->__get("totalCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Compra comp El objeto a actualizar;
     * @return void;
     */
    public function actualizar($comp)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE compra SET idUsuario= :idUsuario, fechaCompra= :fechaCompra, totalCompra= :totalCompra WHERE idCompra= :idCompra";
        $param = array();
        $param[":idCompra"] = $comp->__get("idCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":idUsuario"] = $comp->__get("idUsuario"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":fechaCompra"] = $comp->__get("fechaCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":totalCompra"] = $comp->__get("totalCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($idCompra)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM compra WHERE idCompra= :idCompra";
        $param = array();
        $param[":idCompra"] = $idCompra;
        $this->consultaSimple($consulta, $param);
    }

    public function obtenerPedidosUsuario($idUsuario)
    {
        $consulta = "SELECT * FROM compra where idUsuario = :idUsuario";
        $param = array();
        $param[":idUsuario"] = $idUsuario;
        $this->consultaDatos($consulta, $param);
        foreach ($this->filas as $fila) {
            $comp = new Compra(); //creamos un objeto de la entidad situacion
            $comp->__set("idCompra", $fila['idCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("idUsuario", $fila['idUsuario']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("fechaCompra", $fila['fechaCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $comp->__set("totalCompra", $fila['totalCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->compras[] = $comp; //Guardamos ese objeto en el array de objetos comp
        }
    }
}
