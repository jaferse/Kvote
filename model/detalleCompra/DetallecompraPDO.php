<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("DetallecompraClass.php");
class Daodetallecompra extends DB
{
    public $detallecompras = array();
    /**
     * Constructor de la clase. Llama al constructor de la clase DB.
     * @param string $base nombre de la base de datos
     */
    function __construct($base)
    {
        parent::__construct($base); //Llama al constructor de la clase DB
    }


    /**
     * Lee la tabla detallecompra y devuelve un array de objetos de la clase Detallecompra
     * @return array un array de objetos de la clase Detallecompra
     */
    public function listar()
    {
        $consulta = 'SELECT * FROM detallecompra';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $deta = new Detallecompra(); //creamos un objeto de la entidad situacion
            $deta->__set("idDetalle", $fila['idDetalle']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("idCompra", $fila['idCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("isbn13", $fila['isbn13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("unidades", $fila['unidades']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("precioUnitario", $fila['precioUnitario']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->detallecompras[] = $deta; //Guardamos ese objeto en el array de objetos deta
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($idDetalle)
    {
        $consulta = "SELECT * FROM detallecompra WHERE idDetalle= :idDetalle ";
        $param = array();
        $param[":idDetalle"] = $idDetalle;
        $this->consultaDatos($consulta, $param);
        $deta = new Detallecompra(); //creamos un objeto de la entidad Detallecompra
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $deta->__set("idDetalle", $fila['idDetalle']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("idCompra", $fila['idCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("isbn13", $fila['isbn13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("unidades", $fila['unidades']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("precioUnitario", $fila['precioUnitario']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $deta;
    }


    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $deta El objeto a insertar
     * @return void
     */
    public function insertar($deta)
    { //Se introduce un objeto por parametro que se insertará
        // $consulta = "INSERT INTO detallecompra VALUES (:idCompra, :isbn13, :unidades, :precioUnitario ) ";
        $consulta = "INSERT INTO detallecompra (idCompra, isbn13, unidades, precioUnitario) VALUES (:idCompra, :isbn13, :unidades, :precioUnitario)";
        $param = array();
        // $param[":idDetalle"] = $deta->__get("idDetalle"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":idCompra"] = $deta->__get("idCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":isbn13"] = $deta->__get("isbn13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":unidades"] = $deta->__get("unidades"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":precioUnitario"] = $deta->__get("precioUnitario"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }


    /**;
     * Actualiza una situacion en la base de datos;
     * @param Detallecompra deta El objeto a actualizar;
     * @return void;
     */
    public function actualizar($deta)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE detallecompra SET idCompra= :idCompra, isbn13= :isbn13, unidades= :unidades, precioUnitario= :precioUnitario WHERE idDetalle= :idDetalle";
        $param = array();
        $param[":idDetalle"] = $deta->__get("idDetalle"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":idCompra"] = $deta->__get("idCompra"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":isbn13"] = $deta->__get("isbn13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":unidades"] = $deta->__get("unidades"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":precioUnitario"] = $deta->__get("precioUnitario"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }


    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($idDetalle)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM detallecompra WHERE idDetalle= :idDetalle";
        $param = array();
        $param[":idDetalle"] = $idDetalle;
        $this->consultaSimple($consulta, $param);
    }

    public function obtenerDetalleCompra($idCompra)
    {
        $consulta = "SELECT * FROM detallecompra WHERE idCompra= :idCompra";
        $param = array();
        $param[":idCompra"] = $idCompra;
        $this->consultaDatos($consulta, $param);
        foreach ($this->filas as $fila) {
            $deta = new Detallecompra(); //creamos un objeto de la entidad situacion
            $deta->__set("idDetalle", $fila['idDetalle']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("idCompra", $fila['idCompra']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("isbn13", $fila['isbn13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("unidades", $fila['unidades']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $deta->__set("precioUnitario", $fila['precioUnitario']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->detallecompras[] = $deta; //Guardamos ese objeto en el array de objetos deta
        }
    }

    public function existenComprasISBN($isbn)
    {
        $consulta = "SELECT * FROM detallecompra WHERE isbn13= :isbn13";
        $param = array();
        $param[":isbn13"] = $isbn;
        $this->consultaDatos($consulta, $param);
        return count($this->filas) > 0; //Devuelve true si hay filas, false si no hay
    }
}
