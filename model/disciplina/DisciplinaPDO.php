<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("DisciplinaClass.php");
class Daodisciplina extends DB
{
    public $disciplinas = array();
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
        $consulta = 'SELECT * FROM disciplina';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $disc = new Disciplina(); //creamos un objeto de la entidad situacion
            $disc->__set("artista_id", $fila['artista_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $disc->__set("disciplina", $fila['disciplina']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->disciplinas[] = $disc; //Guardamos ese objeto en el array de objetos disc
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($artista_id, $disciplina)
    {
        $consulta = "SELECT * FROM disciplina WHERE artista_id= :artista_id AND disciplina= :disciplina ";
        $param = array();
        $param[":artista_id"] = $artista_id;
        $param[":disciplina"] = $disciplina;
        $this->consultaDatos($consulta, $param);
        $disc = new Disciplina(); //creamos un objeto de la entidad Disciplina
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $disc->__set("artista_id", $fila['artista_id']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $disc->__set("disciplina", $fila['disciplina']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $disc;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $disc El objeto a insertar
     * @return void
     */
    public function insertar($disc)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO disciplina VALUES (:artista_id, :disciplina ) ";
        $param = array();
        $param[":artista_id"] = $disc->__get("artista_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":disciplina"] = $disc->__get("disciplina"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Disciplina disc El objeto a actualizar;
     * @return void;
     */
    public function actualizar($disc)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE disciplina SET WHERE artista_id= :artista_id AND disciplina= :disciplina";
        $param = array();
        $param[":artista_id"] = $disc->__get("artista_id"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":disciplina"] = $disc->__get("disciplina"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($artista_id, $disciplina)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM disciplina WHERE artista_id= :artista_id AND disciplina= :disciplina";
        $param = array();
        $param[":artista_id"] = $artista_id;
        $param[":disciplina"] = $disciplina;
        $this->consultaSimple($consulta, $param);
    }
}
