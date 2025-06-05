<?php
class DB
{
    //Establecemos una propiedad privada para cada atributo de los parametros de la conexión

    private $pdo; //Propiedad que recoge el objeto PDO creado tras la conexión.

    private  $host = "localhost";
    private  $user = "root";
    private  $pass = "";
    private  $base = "kvote_db";

    //Array de filas con los resultados de las consultas de datos.
    public $filas = array();

    public function __construct(/*$host, $user, $pass, $base*/)
    {
        /*$this->host = $host;
        $this->user = $user;
        $this->pass = $pass;*/
        // $this->base = $base;
    }


    /**
     * Conecta a la base de datos. Si no se ha conectado anteriormente
     * crea un objeto PDO y lo guarda en la propiedad $pdo.
     *
     * @throws PDOException Si hay un error al conectar
     */
    private function conectar()
    {
        try {

            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->base", $this->user, $this->pass);

            # Para que genere excepciones a la hora de reportar errores.
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            echo $e->getMessage();
        }
    }
    /**
     * Cierra la conexión actual.
     *
     * Borra la referencia a la conexión PDO actual en la propiedad $pdo.
     *
     * @return void
     */
    private function cerrar()
    {
        $this->pdo = null;
    }

    /**
     * Realiza una consulta a la base de datos que no devuelve resultados.
     *
     * @param string $consulta La consulta SQL a ejecutar.
     * @param array $param Array con los parámetros de sustitución en la consulta.
     *
     * @return void
     */
    public function consultaSimple($consulta, $param = array())
    {
        try {
            $this->conectar(); //Nos conectamos al servidor DDBB

            $sta = $this->pdo->prepare($consulta); //Preparamos la consulta

            $sta->execute($param); //Ejecutamos con el array de parametros de sustitución.

            $this->cerrar(); //Cerramos 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Realiza una consulta a la base de datos que devuelve los resultados en un array.
     *
     * @param string $consulta La consulta SQL a ejecutar.
     * @param array $param Array con los parámetros de sustitución en la consulta.
     *
     * @return void
     */
    public function consultaDatos($consulta, $param = array())
    {
        try {
            $this->conectar(); //Nos conectamos al servidor DDBB

            $sta = $this->pdo->prepare($consulta); //Preparamos la consulta

            $sta->execute($param); //Ejecutamos con el array de parametros de sustitución.

            $this->filas = $sta->fetchAll(PDO::FETCH_ASSOC); //Devolvemos las filas de la consulta en la propiedad filas.
            $this->cerrar(); //Cerramos 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
