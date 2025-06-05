<?php
require_once("./core/DBClass.php");
require_once("WishlistClass.php");
class Daowishlist extends DB
{
    public $wishlists = array();
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
        $consulta = 'SELECT * FROM wishlist';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $wish = new Wishlist(); //creamos un objeto de la entidad situacion
            $wish->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("producto_isbn_13", $fila['producto_isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("fecha_agregado", $fila['fecha_agregado']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("rating", $fila['rating']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->wishlists[] = $wish; //Guardamos ese objeto en el array de objetos wish
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($usuario_id, $producto_isbn_13)
    {
        $consulta = "SELECT * FROM wishlist WHERE usuario_id= :usuario_id AND producto_isbn_13= :producto_isbn_13 ";
        $param = array();
        $param[":usuario_id"] = $usuario_id;
        $param[":producto_isbn_13"] = $producto_isbn_13;
        $this->consultaDatos($consulta, $param);
        $wish = new Wishlist(); //creamos un objeto de la entidad Wishlist
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $wish->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("producto_isbn_13", $fila['producto_isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("fecha_agregado", $fila['fecha_agregado']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("rating", $fila['rating']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $wish;
    }

    public function getLista($idUsuario)
    {

        $consulta = "SELECT * FROM  wishlist WHERE usuario_id= :usuario_id";
        $param = array();
        $param[":usuario_id"] = $idUsuario;
        $this->consultaDatos($consulta, $param);
        foreach ($this->filas as $fila) {
            $wish = new Wishlist(); //creamos un objeto de la entidad situacion
            $wish->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("producto_isbn_13", $fila['producto_isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("fecha_agregado", $fila['fecha_agregado']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $wish->__set("rating", $fila['rating']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->wishlists[] = $wish; //Guardamos ese objeto en el array de objetos wish
        }
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $wish El objeto a insertar
     * @return void
     */
    public function insertar($wish)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO wishlist VALUES (:usuario_id, :producto_isbn_13, :fecha_agregado, :rating ) ";
        $param = array();
        $param[":usuario_id"] = $wish->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":producto_isbn_13"] = $wish->__get("producto_isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":fecha_agregado"] = $wish->__get("fecha_agregado"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":rating"] = $wish->__get("rating"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Wishlist wish El objeto a actualizar;
     * @return void;
     */
    public function actualizar($wish)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE wishlist SET fecha_agregado= :fecha_agregado, rating= :rating WHERE usuario_id= :usuario_id AND producto_isbn_13= :producto_isbn_13";
        $param = array();
        $param[":usuario_id"] = $wish->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":producto_isbn_13"] = $wish->__get("producto_isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":fecha_agregado"] = $wish->__get("fecha_agregado"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":rating"] = $wish->__get("rating"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($usuario_id, $producto_isbn_13)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM wishlist WHERE usuario_id= :usuario_id AND producto_isbn_13= :producto_isbn_13";
        $param = array();
        $param[":usuario_id"] = $usuario_id;
        $param[":producto_isbn_13"] = $producto_isbn_13;
        $this->consultaSimple($consulta, $param);
    }
}
