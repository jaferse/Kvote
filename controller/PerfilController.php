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
        require_once("model/comentario/ComentarioPDO.php");
        require_once("model/compra/CompraPDO.php");
        require_once("model/detalleCompra/DetallecompraPDO.php");
        require_once("controller/LogInController.php");
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
}
