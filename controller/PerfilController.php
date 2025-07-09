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

    function cambiarPassword(){
        
    }
}
