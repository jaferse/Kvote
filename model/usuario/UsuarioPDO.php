<?php
require_once("./core/DBClass.php");
require_once("UsuarioClass.php");
class Daousuario extends DB
{
    public $usuarios = array();
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
        $consulta = 'SELECT * FROM usuario';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $usua = new Usuario(); //creamos un objeto de la entidad situacion
            $usua->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("apellido1", $fila['apellido1']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("apellido2", $fila['apellido2']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("birth", $fila['birth']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->usuarios[] = $usua; //Guardamos ese objeto en el array de objetos usua
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
        $consulta = "SELECT * FROM usuario WHERE id= :id ";
        $param = array();
        $param[":id"] = $id;
        $this->consultaDatos($consulta, $param);
        $usua = new Usuario(); //creamos un objeto de la entidad Usuario
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $usua->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("apellido1", $fila['apellido1']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("apellido2", $fila['apellido2']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $usua->__set("birth", $fila['birth']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $usua;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $usua El objeto a insertar
     * @return void
     */
    public function insertar($usua)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO usuario VALUES (:id, :nombre, :apellido1, :apellido2, :birth ) ";
        $param = array();
        $param[":id"] = $usua->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $usua->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido1"] = $usua->__get("apellido1"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido2"] = $usua->__get("apellido2"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":birth"] = $usua->__get("birth"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Usuario usua El objeto a actualizar;
     * @return void;
     */
    public function actualizar($usua)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE usuario SET nombre= :nombre, apellido1= :apellido1, apellido2= :apellido2, birth= :birth WHERE id= :id";
        $param = array();
        $param[":id"] = $usua->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $usua->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido1"] = $usua->__get("apellido1"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido2"] = $usua->__get("apellido2"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":birth"] = $usua->__get("birth"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($id)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM usuario WHERE id= :id";
        $param = array();
        $param[":id"] = $id;
        $this->consultaSimple($consulta, $param);
    }

    public function devovlerUltimoId()
    {
        $consulta = "SELECT MAX(id) as id FROM usuario";
        $this->consultaDatos($consulta);
        return $this->filas[0]['id'];
    }


}
