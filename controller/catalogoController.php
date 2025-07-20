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

    

    // public function nosotros()
    // {
    //     $this->view();
    // }

}
