<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("Login_datosClass.php");
class Daologin_datos extends DB
{
    public $login_datoss = array();
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
        $consulta = 'SELECT * FROM login_datos';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $logi = new Login_datos(); //creamos un objeto de la entidad situacion
            $logi->__set("username", $fila['username']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("email", $fila['email']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("password", $fila['password']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("admin", $fila['admin']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->login_datoss[] = $logi; //Guardamos ese objeto en el array de objetos logi
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($username)
    {
        $consulta = "SELECT * FROM login_datos WHERE username= :username ";
        $param = array();
        $param[":username"] = $username;
        $this->consultaDatos($consulta, $param);
        $logi = new Login_datos(); //creamos un objeto de la entidad Login_datos
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $logi->__set("username", $fila['username']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("email", $fila['email']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("password", $fila['password']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("admin", $fila['admin']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $logi;
    }

        /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtenerPorEmail($email)
    {
        $consulta = "SELECT * FROM login_datos WHERE email= :email ";
        $param = array();
        $param[":email"] = $email;
        $this->consultaDatos($consulta, $param);
        $logi = new Login_datos(); //creamos un objeto de la entidad Login_datos
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $logi->__set("username", $fila['username']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("email", $fila['email']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("password", $fila['password']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("usuario_id", $fila['usuario_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $logi->__set("admin", $fila['admin']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $logi;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $logi El objeto a insertar
     * @return void
     */
    public function insertar($logi)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO login_datos VALUES (:username, :email, :password, :usuario_id, :admin ) ";
        $param = array();
        $param[":username"] = $logi->__get("username"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":email"] = $logi->__get("email"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":password"] = $logi->__get("password"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":usuario_id"] = $logi->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":admin"] = $logi->__get("admin"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Login_datos logi El objeto a actualizar;
     * @return void;
     */
    public function actualizar($logi)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE login_datos SET email= :email, password= :password, usuario_id= :usuario_id, admin= :admin WHERE username= :username";
        $param = array();
        $param[":username"] = $logi->__get("username"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":email"] = $logi->__get("email"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":password"] = $logi->__get("password"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":usuario_id"] = $logi->__get("usuario_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":admin"] = $logi->__get("admin"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($username)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM login_datos WHERE username= :username";
        $param = array();
        $param[":username"] = $username;
        $this->consultaSimple($consulta, $param);
    }
}
