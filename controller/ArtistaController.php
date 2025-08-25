<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['admin'] == false) {
    header("Location: index.php?controller=Index&action=view");
}
require_once("./model/artista/ArtistaPDO.php");
class ArtistaController
{
    private $tabla;
    public $artistasPagina = 10;
    public function __construct()
    {
        $this->tabla = new Daoartista(DDBB_NAME);
    }
    public function view()
    {
        require_once("./view/crud/artista.php");
    }

    public function scriptMessage()
    {
        echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Artista&action=view';
            </script>";
    }
    public function create()
    {
        if (isset($_POST["nombre"]) && isset($_POST["apellido1"]) && isset($_POST["pais"])) {
            // Validar los datos del formulario 
            $hoy = date("Y-m-d");
            if (isset($_POST["fecha_nacimiento"]) && $_POST["fecha_nacimiento"] <= $hoy) {
                $artistaObjeto = new Artista();
                $artistaObjeto->__set("nombre", trim($_POST["nombre"]));
                $artistaObjeto->__set("apellido1", trim($_POST["apellido1"]));
                $artistaObjeto->__set("apellido2", trim($_POST["apellido2"]));
                $artistaObjeto->__set("pais", $_POST["pais"]);
                $artistaObjeto->__set("fecha_nacimiento", $_POST["fecha_nacimiento"]);
                $this->tabla->insertar($artistaObjeto);
                $_SESSION['mensaje'] = "2000";
                $_SESSION['type'] = "exito";
            } else {
                $_SESSION['mensaje'] = "1001";
                $_SESSION['type'] = "error";
            }
        } else {
            $_SESSION['mensaje'] = "1000";
            $_SESSION['type'] = "error";
        }
        $this->scriptMessage();
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
        $id = $_GET['parametro'];
        $respuesta = $this->tabla->obtener($id);
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function obtenerNumeroElementos()
    {
        $respuesta = $this->tabla->numeroArtistas();
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function eliminar()
    {
        if (isset($_POST["check"])) {
            //Recorremos los valores del array $_POST["check"] y los mostramos
            foreach ($_POST["check"] as $key => $value) {
                //Eliminamos el dato de la base de datos
                $this->tabla->borrar($key);
            }
            $_SESSION['mensaje'] = "2001";
            $_SESSION['type'] = "exito";
        } else {
            $_SESSION['mensaje'] = "1002";
            $_SESSION['type'] = "error";
        }

        $this->scriptMessage();
    }

    public function actualizar()
    {
        if (isset($_POST["check"])) {
            //Recorremos los valores del array $_POST["check"] y los mostramos
            foreach ($_POST["check"] as $key => $value) {
                $artistaActualizado = new Artista();
                $artistaActualizado->__set("id", $_POST["id_"][$key]);
                $artistaActualizado->__set("nombre", trim($_POST["nombre_"][$key]));
                $artistaActualizado->__set("apellido1", trim($_POST["apellido1_"][$key]));
                $artistaActualizado->__set("apellido2", trim($_POST["apellido2_"][$key]));
                $artistaActualizado->__set("pais", $_POST["pais_"][$key]);
                $artistaActualizado->__set("fecha_nacimiento", $_POST["fecha_nacimiento_"][$key]);
                $this->tabla->actualizar($artistaActualizado);
            }
            $_SESSION['mensaje'] = "2002";
            $_SESSION['type'] = "exito";
        } else {
            $_SESSION['mensaje'] = "1002";
            $_SESSION['type'] = "error";
        }
        $this->scriptMessage();
    }

    public function elementosPorPagina()
    {
        header('Content-Type: application/json');
        echo json_encode($this->artistasPagina);
    }
}
