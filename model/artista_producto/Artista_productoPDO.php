<?php

require_once("./core/DBClass.php");
require_once("Artista_productoClass.php");
class Daoartista_producto extends DB
{
    public $artista_productos = array();
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
        $consulta = 'SELECT * FROM artista_producto';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $arti = new Artista_producto(); //creamos un objeto de la entidad situacion
            $arti->__set("artista_id", $fila['artista_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("trabajo", $fila['trabajo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->artista_productos[] = $arti; //Guardamos ese objeto en el array de objetos arti
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($artista_id, $isbn_13)
    {
        $consulta = "SELECT * FROM artista_producto WHERE artista_id= :artista_id AND isbn_13= :isbn_13 ";
        $param = array();
        $param[":artista_id"] = $artista_id;
        $param[":isbn_13"] = $isbn_13;
        $this->consultaDatos($consulta, $param);
        $arti = new Artista_producto(); //creamos un objeto de la entidad Artista_producto
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $arti->__set("artista_id", $fila['artista_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("trabajo", $fila['trabajo']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $arti;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $arti El objeto a insertar
     * @return void
     */
    public function insertar($arti)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO artista_producto VALUES (:artista_id, :isbn_13, :trabajo ) ";
        $param = array();
        $param[":artista_id"] = $arti->__get("artista_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":isbn_13"] = $arti->__get("isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":trabajo"] = $arti->__get("trabajo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Artista_producto arti El objeto a actualizar;
     * @return void;
     */
    public function actualizar($arti)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE artista_producto SET trabajo= :trabajo WHERE artista_id= :artista_id AND isbn_13= :isbn_13";
        $param = array();
        $param[":artista_id"] = $arti->__get("artista_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":isbn_13"] = $arti->__get("isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":trabajo"] = $arti->__get("trabajo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($artista_id, $isbn_13)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM artista_producto WHERE artista_id= :artista_id AND isbn_13= :isbn_13";
        $param = array();
        $param[":artista_id"] = $artista_id;
        $param[":isbn_13"] = $isbn_13;
        $this->consultaSimple($consulta, $param);
    }

    public function getEnum($columna)
    {
        $consulta = "SELECT COLUMN_TYPE
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_NAME = :tabla
                    AND COLUMN_NAME = :columna
                    AND TABLE_SCHEMA = :schema";
        $param = array();
        $param[":tabla"] = "artista_producto";
        $param[":columna"] = $columna;
        $param[":schema"] = "kvote_db";
        $this->consultaDatos($consulta, $param);
        // echo $this->filas[0]['COLUMN_TYPE'];

        $dato = str_replace("enum(", "", $this->filas[0]['COLUMN_TYPE']);
        $dato = str_replace(")", "", $dato);
        $dato = str_replace("'", "", $dato);
        $dato = explode(",", $dato);
        // echo $dato;
        return $dato;
    }

    public function obtenerArtista_Producto($isbn_13)
    {
        $consulta = "SELECT * FROM artista_producto WHERE isbn_13= :isbn_13 LIMIT 1";
        $param = array();
        // $param[":artista_id"] = $artista_id;
        $param[":isbn_13"] = $isbn_13;
        $this->consultaDatos($consulta, $param);
        $arti = new Artista_producto(); //creamos un objeto de la entidad Artista_producto
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $arti->__set("artista_id", $fila['artista_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("trabajo", $fila['trabajo']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $arti;
    }
}
