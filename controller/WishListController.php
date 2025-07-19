<?php

class WishListController
{


    public function __construct()
    {
        require_once("model/wishlist/WishlistClass.php");
        require_once("model/wishlist/WishlistPDO.php");
        require_once("model/producto/ProductoPDO.php");
        require_once("model/artista_producto/Artista_productoPDO.php");
        require_once("model/productoArtista/ProductoArtista.php");
        require_once("model/artista/ArtistaPDO.php");
        require_once("core/funcionesGenericas.php");


        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function view()
    {
        require_once("view/wishList/wishList.php");
    }

    public function agregarProducto()
    {
        //Si está logeado
        if (
            isset($_SESSION['logueado'])
            && $_SESSION['logueado'] == true
            && isset($_SESSION['username'])
        ) {
            // Crear DAO de wishlist
            $idUsuario = $this->obtenerIdUsuario($_SESSION['username']);
            $daoWishlist = new Daowishlist(DDBB_NAME);

            $whishList = $daoWishlist->obtener($idUsuario, $_GET['isbn']);

            //Si el producto ya está en la wishlist, no lo agregues de nuevo
            if (!$whishList->__get("usuario_id") && !$whishList->__get("producto_isbn_13")) {
                // sacar fecha agregado
                $fechaAgregado = date("Y-m-d");
                // Crear objeto de wishlist
                $whishList = new Wishlist();
                // Asignar valores al objeto
                $whishList->__set("usuario_id", $idUsuario);
                $whishList->__set("producto_isbn_13", $_GET['isbn']);
                $whishList->__set("fecha_agregado", $fechaAgregado);
                // Insertar en la base de datos
                $daoWishlist->insertar($whishList);
                $mensaje = "agregado";
                $type = "exito";
            } else {
                // Si el producto ya está en la wishlist, no lo agrega de nuevo
                $mensaje = "yaEstaEnWishList";
                $type = "error";
            }
            echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . $type . "',
                    message: '" . $mensaje . "'
                }));
                        window.location.href = 'index.php?controller=ProductoDetalle&action=view&isbn=" . $_GET['isbn'] . "';
                    </script>";
        }
        //Si no está logeado
        else {
            $_SESSION['logueado'] = false;
            header("Location: index.php?controller=LogIn&action=view");
        }
    }


    private function obtenerIdUsuario($username)
    {
        require_once("model/login_datos/Login_datosPDO.php");
        $daoLoginDatos = new Daologin_datos(DDBB_NAME);
        $loginDatos = $daoLoginDatos->obtener($username);
        return $loginDatos->usuario_id;
    }

    public function listarWishlist()
    {
        if (isset($_SESSION['logueado']) && $_SESSION['logueado'] == true) {

            //obtener el id del usuario logueado
            $idUsuario = $this->obtenerIdUsuario($_SESSION['username']);

            //sacar los productos de la wishlist del usuario
            $daoWishlist = new Daowishlist(DDBB_NAME);
            $daoWishlist->getLista($idUsuario);
            if (count($daoWishlist->wishlists) > 0) {
                $lista = $daoWishlist->wishlists;

                // //recorremos la lista de productos de la wishlist
                $productos = productoArtista($lista);
            } else {
                $productos = [];
            }
            // //devolver los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($productos);
        } else {
            header("Location: index.php?controller=LogIn&action=view");
        }
    }

    public function eliminarProducto()
    {
        if (isset($_SESSION['logueado']) && $_SESSION['logueado'] == true) {
            //obtener el id del usuario logueado
            $idUsuario = $this->obtenerIdUsuario($_SESSION['username']);
            //sacar el isbn del producto a eliminar
            $isbn = $_GET['isbn'];
            //crear DAO de wishlist
            $daoWishlist = new Daowishlist(DDBB_NAME);
            //eliminar el producto de la wishlist
            $daoWishlist->borrar($idUsuario, $isbn);
            //redireccionar a la wishlist
            header("Location: index.php?controller=WishList&action=view");
        } else {
            header("Location: index.php?controller=LogIn&action=view");
        }
    }
}
