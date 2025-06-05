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
        // session_start();
        if (
            isset($_SESSION['logueado'])
            && $_SESSION['logueado'] == true
            && isset($_SESSION['username'])
        ) {
            // echo $_SESSION['username'];
            // echo $_GET['isbn'];
            // Crear DAO de wishlist
            //Sacar id del usuario
            $idUsuario = $this->obtenerIdUsuario($_SESSION['username']);
            $daoWishlist = new Daowishlist(DDBB_NAME);

            $whishList = $daoWishlist->obtener($idUsuario, $_GET['isbn']);

            // var_dump($whishList);
            //Si el producto ya está en la wishlist, no lo agregues de nuevo
            if (!$whishList->__get("usuario_id") && !$whishList->__get("producto_isbn_13")) {
                // sacar fecha agregado
                $fechaAgregado = date("Y-m-d");
                // echo  "<br>" . $fechaAgregado . "<br>";
                // Crear objeto de wishlist
                $whishList = new Wishlist();
                // Asignar valores al objeto
                $whishList->__set("usuario_id", $idUsuario);
                $whishList->__set("producto_isbn_13", $_GET['isbn']);
                $whishList->__set("fecha_agregado", $fechaAgregado);
                // Insertar en la base de datos
                $daoWishlist->insertar($whishList);
            } else {
                // Si el producto ya está en la wishlist, no lo agrega de nuevo
                $_SESSION['mensajeErrorWishlist'] = "El producto ya está en tu lista de deseos.";
                // echo $_SESSION['mensajeError'];
            }
            // Redirigir a la pagina del producto
            header("Location: index.php?controller=ProductoDetalle&action=view&isbn=" . $_GET['isbn']);
        } else {
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
            if (count($daoWishlist->wishlists)>0) {
                $lista=$daoWishlist->wishlists;
                
                // //recorremos la lista de productos de la wishlist
                $productos = productoArtista($lista);
            }else{
                $productos = [] ;
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
