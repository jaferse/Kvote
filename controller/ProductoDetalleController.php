<?php
require_once("./model/producto/ProductoPDO.php");
require_once("core/funcionesGenericas.php");
class ProductoDetalleController
{
    private $tabla;

    public function __construct()
    {
        $this->tabla = new Daoproducto(DDBB_NAME);
    }
    /**
     * Muestra el detalle de un producto si se ha proporcionado su isbn_13 en la url, en caso contrario
     * muestra la vista de la tienda principal.
     *
     * @return void
     */
    public function view()
    {
        if (isset($_GET['isbn'])) {
            require_once("./view/producto/productoDetalle.php");
        } else {
            require_once("./view/index.php");
        }
    }

    /**
     * Obtiene un producto por su isbn_13 junto con su artista y lo devuelve en formato JSON.
     *
     * @param string $isbn_13 isbn_13 del producto a obtener
     *
     * @return void
     */
    public function getProducto($isbn_13)
    {
        $producto = $this->tabla->obtener($isbn_13);
        $productoArtista = productoArtistaDetalle($producto);
        header('Content-Type: application/json');
        echo json_encode($productoArtista);
    }
}
