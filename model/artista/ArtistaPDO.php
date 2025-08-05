<?php
//Revisar la situación del path
require_once("./core/DBClass.php"); //Llamamos a la clase DB para poder usarla
require_once("ArtistaClass.php");
class Daoartista extends DB
{
    public $artistas = array();
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
        $consulta = 'SELECT * FROM artista';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $arti = new Artista(); //creamos un objeto de la entidad situacion
            $arti->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("apellido1", $fila['apellido1']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("apellido2", $fila['apellido2']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("pais", $fila['pais']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("fecha_nacimiento", $fila['fecha_nacimiento']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->artistas[] = $arti; //Guardamos ese objeto en el array de objetos arti
        }
    }

        public function numeroArtistas()
    {
        $consulta = 'SELECT count(*) as total FROM artista';
        $this->consultaDatos($consulta);
        return $this->filas[0]['total'];
    }

    public function listarPaginado($paginaActual, $productosPagina)
    {
        $consulta = 'SELECT * FROM artista ORDER BY id ASC LIMIT  ' . ($paginaActual - 1) * $productosPagina . ',' . $productosPagina;
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $arti = new Artista(); //creamos un objeto de la entidad situacion
            $arti->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("apellido1", $fila['apellido1']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("apellido2", $fila['apellido2']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("pais", $fila['pais']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("fecha_nacimiento", $fila['fecha_nacimiento']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->artistas[] = $arti; //Guardamos ese objeto en el array de objetos arti
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Artista El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($id)
    {
        $consulta = "SELECT * FROM artista WHERE id= :id ";
        $param = array();
        $param[":id"] = $id;
        $this->consultaDatos($consulta, $param);
        $arti = new Artista(); //creamos un objeto de la entidad Artista
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $arti->__set("id", $fila['id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("apellido1", $fila['apellido1']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("apellido2", $fila['apellido2']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("pais", $fila['pais']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $arti->__set("fecha_nacimiento", $fila['fecha_nacimiento']); //Le asignamos a las propiedades del objetos los campos de esa fila
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
        $consulta = "INSERT INTO artista VALUES (:id, :nombre, :apellido1, :apellido2, :pais, :fecha_nacimiento ) ";
        $param = array();
        $param[":id"] = $arti->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $arti->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido1"] = $arti->__get("apellido1"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido2"] = $arti->__get("apellido2"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":pais"] = $arti->__get("pais"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":fecha_nacimiento"] = $arti->__get("fecha_nacimiento"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza un Artista en la base de datos;
     * @param Artista arti El objeto a actualizar;
     * @return void;
     */
    public function actualizar($arti)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE artista SET nombre= :nombre, apellido1= :apellido1, apellido2= :apellido2, pais= :pais, fecha_nacimiento= :fecha_nacimiento WHERE id= :id";
        $param = array();
        $param[":id"] = $arti->__get("id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $arti->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido1"] = $arti->__get("apellido1"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":apellido2"] = $arti->__get("apellido2"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":pais"] = $arti->__get("pais"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":fecha_nacimiento"] = $arti->__get("fecha_nacimiento"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($id)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM artista WHERE id= :id";
        $param = array();
        $param[":id"] = $id;
        $this->consultaSimple($consulta, $param);
    }

    /**
     * Obtiene el siguiente ID de auto-incremento para la tabla 'artista'.
     *
     * @return int El próximo ID disponible para insertar un nuevo registro en la tabla 'artista'.
     */

    public function obtenerId()
    {
        $consulta = " SELECT `AUTO_INCREMENT` as idActual FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'kvote_db' AND TABLE_NAME = 'artista'";
        $this->consultaDatos($consulta);

        return ($this->filas[0]['idActual']); //Devolvemos el id del artista siguiente a asignar
    }
}
