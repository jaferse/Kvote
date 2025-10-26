<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("TarjetaClass.php");
class Daotarjeta extends DB
{
    public $tarjetas = array();
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
        $consulta = 'SELECT * FROM tarjeta';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $tarj = new Tarjeta(); //creamos un objeto de la entidad situacion
            $tarj->__set("numero_tarjeta", $fila['numero_tarjeta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("nombre_titular", $fila['nombre_titular']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("emisor_tarjeta", $fila['emisor_tarjeta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("cvv_cvc", $fila['cvv_cvc']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("tipo_tarjeta", $fila['tipo_tarjeta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("fecha_caducidad", $fila['fecha_caducidad']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->tarjetas[] = $tarj; //Guardamos ese objeto en el array de objetos tarj
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($numero_tarjeta)
    {
        $consulta = "SELECT * FROM tarjeta WHERE numero_tarjeta= :numero_tarjeta ";
        $param = array();
        $param[":numero_tarjeta"] = $numero_tarjeta;
        $this->consultaDatos($consulta, $param);
        $tarj = new Tarjeta(); //creamos un objeto de la entidad Tarjeta
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $tarj->__set("numero_tarjeta", $fila['numero_tarjeta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("nombre_titular", $fila['nombre_titular']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("emisor_tarjeta", $fila['emisor_tarjeta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("cvv_cvc", $fila['cvv_cvc']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("tipo_tarjeta", $fila['tipo_tarjeta']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("fecha_caducidad", $fila['fecha_caducidad']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $tarj->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $tarj;
    }

    public function existeTarjeta($tarjeta)
    {
        $consulta = "SELECT EXISTS(
                                        SELECT 1 
                                        FROM tarjeta 
                                        WHERE numero_tarjeta = :numero_tarjeta
                                    ) AS existe";
        $param = array();
        $param[":numero_tarjeta"] = $tarjeta;
        $this->consultaDatos($consulta, $param);
        $tarj = new Tarjeta(); //creamos un objeto de la entidad Tarjeta
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
        }
        return $fila['existe'];
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $tarj El objeto a insertar
     * @return void
     */
    public function insertar($tarj)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO tarjeta VALUES (:numero_tarjeta, :nombre_titular, :emisor_tarjeta, :cvv_cvc, :tipo_tarjeta, :fecha_caducidad, :usuario_id ) ";
        $param = array();
        $param[":numero_tarjeta"] = $tarj->__get("numero_tarjeta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre_titular"] = $tarj->__get("nombre_titular"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":emisor_tarjeta"] = $tarj->__get("emisor_tarjeta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":cvv_cvc"] = $tarj->__get("cvv_cvc"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":tipo_tarjeta"] = $tarj->__get("tipo_tarjeta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":fecha_caducidad"] = $tarj->__get("fecha_caducidad"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":usuario_id"] = $tarj->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Tarjeta tarj El objeto a actualizar;
     * @return void;
     */
    public function actualizar($tarj)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE tarjeta SET nombre_titular= :nombre_titular, emisor_tarjeta= :emisor_tarjeta, cvv_cvc= :cvv_cvc, tipo_tarjeta= :tipo_tarjeta, fecha_caducidad= :fecha_caducidad, usuario_id= :usuario_id WHERE numero_tarjeta= :numero_tarjeta";
        $param = array();
        $param[":numero_tarjeta"] = $tarj->__get("numero_tarjeta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre_titular"] = $tarj->__get("nombre_titular"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":emisor_tarjeta"] = $tarj->__get("emisor_tarjeta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":cvv_cvc"] = $tarj->__get("cvv_cvc"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":tipo_tarjeta"] = $tarj->__get("tipo_tarjeta"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":fecha_caducidad"] = $tarj->__get("fecha_caducidad"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":usuario_id"] = $tarj->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($numero_tarjeta)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM tarjeta WHERE numero_tarjeta= :numero_tarjeta";
        $param = array();
        $param[":numero_tarjeta"] = $numero_tarjeta;
        $this->consultaSimple($consulta, $param);
    }

    public function borrarPorId($id)
    {
        $consulta = " DELETE FROM tarjeta WHERE usuario_id= :usuario_id";
        $param = array();
        $param[":usuario_id"] = $id;
        $this->consultaSimple($consulta, $param);
    }


    public function obtenerTarjetas($id){
        $consulta = "SELECT * FROM tarjeta WHERE usuario_id= :id";
        $param = array();
        $param[":id"] = $id;
        $this->consultaDatos($consulta, $param);
        return $this->filas;
    }

    /**
     * Obtiene el enum de una columna de la tabla tarjeta
     *
     * @param string $columna La columna que se quiere obtener el enum
     *
     * @return array El enum de la columna en cuestión
     */
    public function getEnum($columna)
    {
        $consulta = "SELECT COLUMN_TYPE
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_NAME = :tabla
                    AND COLUMN_NAME = :columna
                    AND TABLE_SCHEMA = :schema";
        $param = array();
        $param[":tabla"] = "tarjeta";
        $param[":columna"] = $columna;
        $param[":schema"] = "kvote_db";
        $this->consultaDatos($consulta, $param);

        $dato = str_replace("enum(", "", $this->filas[0]['COLUMN_TYPE']);
        $dato = str_replace(")", "", $dato);
        $dato = str_replace("'", "", $dato);
        $dato = explode(",", $dato);
        return $dato;
    }
}
