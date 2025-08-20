<?php

class PerfilController
{
    public function __construct()
    {
        session_start();
        require_once("model/login_datos/Login_datosPDO.php");
        require_once("model/usuario/UsuarioPDO.php");
        require_once("model/tarjeta/TarjetaPDO.php");
        require_once("model/direccion/DireccionPDO.php");
        require_once("model/direccion/DireccionClass.php");
        require_once("model/comentario/ComentarioPDO.php");
        require_once("model/compra/CompraPDO.php");
        require_once("model/detalleCompra/DetallecompraPDO.php");
        require_once("controller/LogInController.php");
        require_once("model/provincia/ProvinciaPDO.php");
        require_once("model/pais/PaisPDO.php");
        require_once("model/localidad/LocalidadPDO.php");
        require_once("model/tarjeta/TarjetaPDO.php");
        require_once("model/tarjeta/TarjetaClass.php");
        if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] != true) {
            header("Location: index.php?controller=Index&action=view");
            header("Location: index.php?controller=LogIn&action=view");
        }
    }
    public function index()
    {
        require_once("view/perfil/perfil.php");
    }

    public function baja($username)
    {
        try {
            $loginDatosDao = new Daologin_datos(DDBB_NAME);
            $loginDatos = $loginDatosDao->obtener($username);
            $idUsuario = $loginDatos->__get("usuario_id");

            //Borrar tarjetas asociadas al usuario
            $tarjetaDao = new Daotarjeta(DDBB_NAME);
            $tarjetaDao->borrarPorId($idUsuario);

            // borrar direcciones asociadas al usuario
            $direccionDao = new Daodireccion(DDBB_NAME);
            $direccionDao->borrarPorIdUsuario($idUsuario);

            //borrar comentarios del usuario

            $comentarioDao = new Daocomentario(DDBB_NAME);
            $comentarioDao->borrarPorIdUsuario($idUsuario);

            //Sacar pedidos del usuario 
            $compraDao = new Daocompra(DDBB_NAME);
            $detalleCompraDao = new Daodetallecompra(DDBB_NAME);
            $compraDao->obtenerPedidosUsuario($idUsuario);
            $compras = $compraDao->compras;
            foreach ($compras as $key => $compra) {
                //    echo "Id compra:". $compra->idCompra . "<br>";
                $detalleCompraDao->obtenerDetalleCompra($compra->idCompra);

                foreach ($detalleCompraDao->detallecompras as $key => $detalle) {
                    // echo "Id Detalle:". $detalle->idDetalle . "<br>";
                    $detalleCompraDao->borrar($detalle->idDetalle);
                }
                //    echo "<br>";
                $compraDao->borrar($compra->idCompra);
            }
            //borrar pedidos del usuario
            $compraDao = new Daocompra(DDBB_NAME);
            $compraDao->borrarporIdUsuario($idUsuario);

            //Borrar el login_datos del usuario

            $loginDatosDao->borrar($username);

            //borrar el usuario de la base de datos
            $usuarioDao = new Daousuario(DDBB_NAME);
            $usuarioDao->borrar($idUsuario);
            //Respuesta de éxito
            $response = [
                'success' => true,
                'message' => 'El usuario se ha borrado correctamente'
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
            //Cerrar sesión
            session_destroy();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function cambiarPassword()
    {
        $loginDatosDao = new Daologin_datos(DDBB_NAME);
        //Obtenemos los datos 
        $passWordOld = $_POST['passWordOld'];
        $passWordNew = $_POST['passWordNew'];
        //Verificar que la contraseña actual es correcta
        $datosUser = $loginDatosDao->obtenerId($_POST['idUsuario']);

        //Si coincide la contraseña actual con la que tenemos en la base de datos y el usuario con el conectado
        if (password_verify($passWordOld, $datosUser->__get("password")) && $datosUser->__get("usuario_id") == $_SESSION['usernameId']) {
            //Cambiar la contraseña
            if ($passWordOld !== $passWordNew) {
                $datosUser->__set("password", password_hash($passWordNew, PASSWORD_ARGON2ID));
                $loginDatosDao->actualizar($datosUser);
                $_SESSION['mensaje'] = "2004";
                $_SESSION['type'] = "exito";
            } else {
                $_SESSION['mensaje'] = "3000";
                $_SESSION['type'] = "warning";
            }
        } else {
            $_SESSION['mensaje'] = "1007";
            $_SESSION['type'] = "error";
        }
        echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Perfil&action=view';
            </script>";

        exit;
    }
    public function obtenerDatosUsuario()
    {
        $usuarioDao = new Daousuario(DDBB_NAME);
        $response =  $usuarioDao->obtener($_SESSION['usernameId']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function cambiarDatosUsuario()
    {
        if (
            isset($_POST['idUsuario']) &&
            isset($_POST['nombre']) &&
            isset($_POST['Apellido1']) &&
            isset($_POST['Apellido2']) &&
            !empty($_POST['idUsuario']) &&
            !empty($_POST['nombre']) &&
            !empty($_POST['Apellido1']) &&
            !empty($_POST['Apellido2']) &&
            $_POST['idUsuario'] == $_SESSION['usernameId'] &&
            strlen($_POST['nombre']) <= 50 &&
            strlen($_POST['Apellido1']) <= 45 &&
            strlen($_POST['Apellido2']) <= 45
        ) {
            $usuarioDao = new Daousuario(DDBB_NAME);

            $datoUsuario =  $usuarioDao->obtener($_POST['idUsuario']);
            $datoUsuario->__set("nombre", $_POST['nombre']);
            $datoUsuario->__set("apellido1", $_POST['Apellido1']);
            $datoUsuario->__set("apellido2", $_POST['Apellido2']);

            $usuarioDao->actualizar($datoUsuario);

            $_SESSION['mensaje'] = "2003";
            $_SESSION['type'] = "exito";
        } else {
            $_SESSION['mensaje'] = "1006";
            $_SESSION['type'] = "error";
        }
        echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Perfil&action=view';
            </script>";
    }
    public function obtenerComunidades()
    {
        // echo $_GET['parametro'];
        $provinciaDao = new Daoprovincia(DDBB_NAME);
        $comunidades = $provinciaDao->listarPorPais($_GET['parametro']);
        header('Content-Type: application/json');
        echo json_encode($comunidades);
    }
    public function obtenerLocalidades()
    {
        // echo $_GET['parametro'];
        $codPais = explode("-", $_GET['parametro'])[0];
        $codProvincia = explode("-", $_GET['parametro'])[1];
        // echo "CodPais: $codPais, CodProvincia: $codProvincia";
        $localidadDao = new Daolocalidad(DDBB_NAME);
        $localidades = $localidadDao->listarPorPaisYProvincia($codPais, $codProvincia);
        header('Content-Type: application/json');
        echo json_encode($localidades);
    }
    public function obtenerDirecciones()
    {
        $direccionDao = new Daodireccion(DDBB_NAME);
        $direcciones = $direccionDao->listarPorUsuario_id($_SESSION['usernameId']);
        header('Content-Type: application/json');
        echo json_encode($direcciones);
    }

    public function agregarDireccion()
    {
        //Si existen los campos de la direccion y el id del usuario.
        if (
            isset($_POST['pais']) &&
            isset($_POST['comunidad']) &&
            isset($_POST['codPostal']) &&
            isset($_POST['localidad']) &&
            isset($_POST['calle']) &&
            isset($_POST['numero']) &&
            isset($_SESSION['usernameId']) &&
            !empty($_POST['pais']) &&
            !empty($_POST['comunidad']) &&
            !empty($_POST['codPostal']) &&
            !empty($_POST['localidad']) &&
            !empty($_POST['calle']) &&
            !empty($_POST['numero'])
        ) {
            if (
                strlen($_POST['pais']) == 2 &&
                strlen($_POST['comunidad']) < 16 &&
                ((($_POST['pais'] == 'ES' || $_POST['pais'] == 'FR') && strlen($_POST['codPostal']) == 5) ||
                    ($_POST['pais'] == 'PT' && strlen($_POST['codPostal']) == 7)) &&
                strlen($_POST['localidad']) <= 100 &&
                strlen($_POST['calle']) <= 70 &&
                strlen($_POST['numero']) <= 11
            ) {
                $direccionDao = new Daodireccion(DDBB_NAME);
                $direccion = new Direccion();
                $direccion->__set("paisISO", $_POST['pais']);
                $direccion->__set("provinciaMatricula", $_POST['comunidad']);
                $direccion->__set("codigo_postal", $_POST['codPostal']);
                $direccion->__set("localidad", $_POST['localidad']);
                $direccion->__set("calle", $_POST['calle']);
                $direccion->__set("numero", $_POST['numero']);
                $direccion->__set("piso", $_POST['piso']);
                $direccion->__set("puerta", $_POST['puerta']);
                $direccion->__set("usuario_id", $_SESSION['usernameId']);

                $direccionDao->insertar($direccion);
                $_SESSION['mensaje'] = "2005";
                $_SESSION['type'] = "exito";
            } else {
                $_SESSION['mensaje'] = "1006";
                $_SESSION['type'] = "error";
            }
        } else {
            $_SESSION['mensaje'] = "1008";
            $_SESSION['type'] = "error";
        }
        echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Perfil&action=view';
                </script>";
    }

    public function borrarDireccion()
    {
        if (isset($_GET['parametro']) && !empty($_GET['parametro'])) {
            $idDireccion = $_GET['parametro'];
            $direccionDao = new Daodireccion(DDBB_NAME);
            $direccionDao->borrar($idDireccion);
            $_SESSION['mensaje'] = "2006";
            $_SESSION['type'] = "exito";
        } else {
            $_SESSION['mensaje'] = "1000";
            $_SESSION['type'] = "error";
        }
        echo json_encode([
            "type" => $_SESSION['type'],
            "message" => $_SESSION['mensaje']
        ]);
    }

    public function obtenerNombrePais()
    {
        $isoPais = $_GET['parametro'];
        $paisDao = new Daopais(DDBB_NAME);
        $pais = $paisDao->obtenerNombre($isoPais);
        header('Content-Type: application/json');
        echo json_encode($pais);
    }
    public function obtenerNombreProvincia()
    {
        $isoPais = explode(":", $_GET['parametro'])[0];
        $matriculaProvincia = explode(":", $_GET['parametro'])[1];
        $provinciaDao = new Daoprovincia(DDBB_NAME);
        $provincia = $provinciaDao->obtenerNombre($matriculaProvincia, $isoPais);
        header('Content-Type: application/json');
        echo json_encode($provincia);
    }

    public function addCreditCard()
    {
        //Trim de todo
        $numeroTarjeta = trim($_POST['numeroTarjeta']);
        $nombre_titular = trim($_POST['nombre_titular']);
        $emisor_tarjeta = trim($_POST['emisor_tarjeta']);
        $cvv_cvc = trim($_POST['cvv_cvc']);
        $tipo_tarjeta = trim($_POST['tipo_tarjeta']);
        $fecha_caducidad = trim($_POST['fecha_caducidad']);
        //Eliminar del numero de tarjeta espacios y guiones
        $numeroTarjeta = str_replace(" ", "", $numeroTarjeta);
        $numeroTarjeta = str_replace("-", "", $numeroTarjeta);
        //Verificar que los datos sean correctos
        if (
            ctype_digit($numeroTarjeta) &&
            strlen($numeroTarjeta) == 16 &&
            strlen($nombre_titular) <= 200 &&
            $fecha_caducidad > date("Y-m-d") &&
            (strlen($cvv_cvc) == 3 || strlen($cvv_cvc) == 4) &&
            ctype_digit($cvv_cvc) &&
            !empty($nombre_titular) &&
            !empty($emisor_tarjeta) &&
            !empty($cvv_cvc) &&
            !empty($tipo_tarjeta) &&
            !empty($fecha_caducidad)
        ) {

            //Validar que no existe ese numero de tarjeta
            if (!$this->existeTarjeta($numeroTarjeta)) {
                $daoTarjeta = new Daotarjeta(DDBB_NAME);
                $tarjeta = new Tarjeta();
                $tarjeta->__set("numero_tarjeta", $numeroTarjeta);
                $tarjeta->__set("nombre_titular", $nombre_titular);
                $tarjeta->__set("emisor_tarjeta", $emisor_tarjeta);
                $tarjeta->__set("cvv_cvc", $cvv_cvc);
                $tarjeta->__set("tipo_tarjeta", $tipo_tarjeta);
                $tarjeta->__set("fecha_caducidad", $fecha_caducidad);
                $tarjeta->__set("usuario_id", $_SESSION['usernameId']);

                $daoTarjeta->insertar($tarjeta);
                $_SESSION['mensaje'] = "2007";
                $_SESSION['type'] = "exito";
            } else {
                $_SESSION['mensaje'] = "1009";
                $_SESSION['type'] = "error";
            }
        } else {
            $_SESSION['mensaje'] = "1006";
            $_SESSION['type'] = "error";
        }
        echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Perfil&action=view';
            </script>";
    }

    public function emisoresTarjeta()
    {
        $daoTarjeta = new Daotarjeta(DDBB_NAME);
        $response = $daoTarjeta->getEnum('emisor_tarjeta');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function tiposTarjeta()
    {
        $daoTarjeta = new Daotarjeta(DDBB_NAME);
        $response = $daoTarjeta->getEnum('tipo_tarjeta');
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function existeTarjeta($numeroTarjeta)
    {
        $daoTarjeta = new Daotarjeta(DDBB_NAME);
        return $daoTarjeta->existeTarjeta($numeroTarjeta);
    }
}
