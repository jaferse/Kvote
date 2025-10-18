<?php
require_once("model/producto/ProductoPDO.php");
require_once("core/funcionesGenericas.php");
require_once("model/productoArtista/ProductoArtista.php");
class CatalogoController
{
    private $tablaProductos;
    public function __construct()
    {
        $this->tablaProductos = new Daoproducto(DDBB_NAME);
    }
    public function view()
    {
        require_once("./view/comic/catalogo.php");
    }

    public function comic()
    {
        $this->view();
    }
    public function libros()
    {
        $this->view();
    }
    public function novedades()
    {
        $this->view();
    }
    public function autor()
    {
        $this->view();
    }
    public function categoria()
    {
        $this->view();
    }
    public function subtipo()
    {
        $this->view();
    }
    public function formato()
    {
        $this->view();
    }
    public function editorial()
    {
        $this->view();
    }
    public function coleccion()
    {
        $this->view();
    }
    public function buscar()
    {
        $_SESSION['busqueda'] = $_GET['parametro'];
        $this->view();
    }
    public function getComic()
    {
        $this->tablaProductos->listarComic();
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductos('comic');
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    public function getLibros()
    {
        $this->tablaProductos->listarLibros();
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductos('libro');
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    public function getNovedades()
    {
        $this->tablaProductos->listarNovedades();
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductos();
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    //Sin implementar bien
    public function getAutor()
    {
        $this->tablaProductos->listarPorAutor($_GET['parametro']);
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductosFiltro('Autor', $_GET['parametro']);
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    public function getCategoria()
    {
        $tipo = 'tipo';
        $this->tablaProductos->listarPorTipo($tipo, $_GET['parametro']);
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductosFiltro($tipo, $_GET['parametro']);
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    public function getSubtipo()
    {
        $tipo = 'subtipo';
        $this->tablaProductos->listarPorTipo($tipo, $_GET['parametro']);
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductosFiltro($tipo, $_GET['parametro']);
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    public function getFormato()
    {
        $tipo = 'formato';
        $this->tablaProductos->listarPorTipo($tipo, $_GET['parametro']);
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductosFiltro($tipo, $_GET['parametro']);
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    public function getEditorial()
    {
        $tipo = 'editorial';
        $this->tablaProductos->listarPorTipo($tipo, $_GET['parametro']);
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductosFiltro($tipo, $_GET['parametro']);
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
    public function getColeccion()
    {
        $tipo = 'coleccion';
        $this->tablaProductos->listarPorTipo($tipo, $_GET['parametro']);
        $productos = $this->tablaProductos->productos;
        $productoArtista['productos'] = productoArtista($productos);
        $productoArtista['total'] = $this->tablaProductos->numeroProductosFiltro($tipo, $_GET['parametro']);
        $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }

    public function getBuscar()
    {
        $this->tablaProductos->buscar($_GET['parametro']);
        $productos = $this->tablaProductos->productos;
        //Si hay productos los asignamos, si no devolvemos un array vacio
        if ($productos) {
            $productoArtista['productos'] = productoArtista($productos);
            $productoArtista['total'] = $this->tablaProductos->numeroProductosBusqueda($_GET['parametro']);
            $productoArtista['productoPaginas'] = $this->tablaProductos->getProductoPaginas();
        }else{
            $productoArtista=[];
        }
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
}
