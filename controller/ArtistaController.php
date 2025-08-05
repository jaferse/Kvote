<?php
require_once("./model/artista/ArtistaPDO.php");
class ArtistaController
{
    private $tabla;
    public $artistasPagina=10;
    public function __construct()
    {
        $this->tabla = new Daoartista(DDBB_NAME);
    }
    public function view()
    {
        require_once("./view/crud/artista.php");
    }


    public function create()
    {
        if (isset($_POST["nombre"]) && isset($_POST["apellido1"]) && isset($_POST["pais"])) {
            // Validar los datos del formulario 

            $artistaObjeto = new Artista();
            $artistaObjeto->__set("nombre", $_POST["nombre"]);
            $artistaObjeto->__set("apellido1", $_POST["apellido1"]);
            $artistaObjeto->__set("apellido2", $_POST["apellido2"]);
            $artistaObjeto->__set("pais", $_POST["pais"]);
            $artistaObjeto->__set("fecha_nacimiento", $_POST["fecha_nacimiento"]);
            $this->tabla->insertar($artistaObjeto);
            echo "Artista insertado correctamente";
            header("Location: index.php?controller=Artista&action=view&estado=1");
        } else {
            header("Location: index.php?controller=Artista&action=view&estado=0");
        }
    }

    public function listar()
    {
        $this->tabla->listar();
        return $this->tabla->artistas;
    }

    public function obtenerArtistas()
    {
        $this->tabla->listarPaginado($_GET['page'], $this->artistasPagina);
        $respuesta = $this->tabla->artistas;
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    
    public function obtenerAutorPorId()
    {
        $id=$_GET['parametro'];
        $respuesta=$this->tabla->obtener($id);
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function obtenerNumeroElementos(){
        $respuesta= $this->tabla->numeroArtistas();
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function eliminar()
    {
        if (isset($_POST["check"])) {
            //Recorremos los valores del array $_POST["check"] y los mostramos
            foreach ($_POST["check"] as $key => $value) {
                echo $key . "<br>";
                //Eliminamos el dato de la base de datos
                $this->tabla->borrar($key);
            }
            header("Location: index.php?controller=Artista&action=view&estado=1");
        } else {
            header("Location: index.php?controller=Artista&action=view&estado=0");
        }
        //Acceder a a los valores marcados y eliminarlos
    }

    public function actualizar()
    {
        if (isset($_POST["check"])) {
            echo "Actualizar Artista";
            //Recorremos los valores del array $_POST["check"] y los mostramos

            foreach ($_POST["check"] as $key => $value) {
                // echo $_POST["nombre"][$key] . "<br>";
                $artistaActualizado = new Artista();
                $artistaActualizado->__set("id", $_POST["id_"][$key]);
                $artistaActualizado->__set("nombre", $_POST["nombre_"][$key]);
                $artistaActualizado->__set("apellido1", $_POST["apellido1_"][$key]);
                $artistaActualizado->__set("apellido2", $_POST["apellido2_"][$key]);
                $artistaActualizado->__set("pais", $_POST["pais_"][$key]);
                $artistaActualizado->__set("fecha_nacimiento", $_POST["fecha_nacimiento_"][$key]);
                $this->tabla->actualizar($artistaActualizado);
            }
            header("Location: index.php?controller=Artista&action=view&estado=1");
        } else {
            header("Location: index.php?controller=Artista&action=view&estado=0");
        }
    }

    public function elementosPorPagina(){
        header('Content-Type: application/json');
        echo json_encode($this->artistasPagina);
    }

}
