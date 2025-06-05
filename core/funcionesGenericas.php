<?php
require_once("model/producto/ProductoPDO.php");
require_once("model/artista_producto/Artista_productoPDO.php");
require_once("model/artista/ArtistaPDO.php");
require_once("model/productoArtista/ProductoArtista.php");

/**
 * Muestra una imagen BLOD en un input file
 * 
 * @param string $blod Contenido BLOD de la imagen
 * @param string $nombreColumna Nombre de la columna que se va a mostrar
 * @param string $pk Primary key de la fila que se va a mostrar
 * 
 * @return void
 */

function mostrarBlod_File($blod, $nombreColumna, $pk)
{
    echo "<img src='data:image/jpg;base64," . $blod . "' width='120px'>";
    echo "<input type='file' name='" . $nombreColumna . "[" . $pk . "]' multiple>";
}

/**
 * Convierte un archivo temporal en un BLOD
 * 
 * @param string $tmp_name Ruta del archivo temporal
 * 
 * @return string Contenido BLOD del archivo
 */
function file_Blod($tmp_name)
{

    $imagenContenido = file_get_contents($tmp_name);
    $imagenContenido = base64_encode($imagenContenido);
    // $objectClass->__set($nombreColumna, $imagenContenido);
    return $imagenContenido;
}

/**
 * Comprueba si un producto es un cómic basándose en su ISBN.
 * 
 * @param string $isbn ISBN del producto a comprobar.
 * 
 * @return bool Devuelve true si es un cómic, false en caso contrario.
 */
function comprobarSiEsComic($isbn)
{
    $productoDao = new  Daoproducto("kvote_db");
    $producto = $productoDao->obtener($isbn);
    $esComic = true;
    if (
        $producto->tipo == 'Novela' ||
        $producto->tipo == 'No Ficción'
        || $producto->tipo == 'Antología'
        || $producto->tipo == 'Otro'
    ) {
        $esComic = false;
    }
    return $esComic;
}

/**
 * Asocia productos con sus respectivos artistas y devuelve un array de objetos ProductoArtista.
 * 
 * @param array $arrayProductos Array de productos o wishlist.
 * 
 * @return array Array de objetos ProductoArtista.
 */
function productoArtista($arrayProductos)
{
    foreach ($arrayProductos as $key => $value) {

        if (get_class($value) === "Wishlist") {
            //sacamos los productos de la wishlist
            $daoProducto = new Daoproducto(DDBB_NAME);
            $producto = $daoProducto->obtener($value->__get('producto_isbn_13'));
            // sacamos los artistas del producto
            $daoArtistaProducto = new Daoartista_producto(DDBB_NAME);

            $artista = $daoArtistaProducto->obtenerArtista_Producto($value->__get('producto_isbn_13'));
            $DaoArtista = new Daoartista(DDBB_NAME);
            $artista = $DaoArtista->obtener($artista->__get("artista_id"));
        } else {
            $producto = $value;
            //sacamos los artistas del producto
            $daoArtistaProducto = new Daoartista_producto(DDBB_NAME);
            $artista = $daoArtistaProducto->obtenerArtista_Producto($producto->__get("isbn_13"));
            $DaoArtista = new Daoartista(DDBB_NAME);
            $artista = $DaoArtista->obtener($artista->__get("artista_id"));
        }


        //asignamos los artistas al producto
        $productoArtista = new ProductoArtista();
        $productoArtista->__set("isbn_13", $producto->__get("isbn_13"));
        $productoArtista->__set("portada", $producto->__get("portada"));
        $productoArtista->__set("nombre", $producto->__get("nombre"));
        $productoArtista->__set("coleccion", $producto->__get("coleccion"));
        $productoArtista->__set("numero", $producto->__get("numero"));
        $productoArtista->__set("tipo", $producto->__get("tipo"));
        $productoArtista->__set("formato", $producto->__get("formato"));
        $productoArtista->__set("paginas", $producto->__get("paginas"));
        $productoArtista->__set("subtipo", $producto->__get("subtipo"));
        $productoArtista->__set("editorial", $producto->__get("editorial"));
        $productoArtista->__set("anio_publicacion", $producto->__get("anio_publicacion"));
        $productoArtista->__set("sinopsis", $producto->__get("sinopsis"));
        $productoArtista->__set("precio", $producto->__get("precio"));
        $productoArtista->__set("stock", $producto->__get("stock"));
        $productoArtista->__set("nombreArtista", $artista->__get("nombre"));
        $productoArtista->__set("apellido1", $artista->__get("apellido1"));
        $productoArtista->__set("apellido2", $artista->__get("apellido2"));
        $productos[] = $productoArtista;
    }
    return $productos;
}


/**
 * Obtiene los detalles de un producto junto con su artista y lo devuelve como un objeto ProductoArtista.
 * 
 * @param object $producto Objeto del producto a obtener.
 * 
 * @return object ProductoArtista Objeto con los detalles del producto y su artista.
 */
function productoArtistaDetalle($producto)
{
    //sacamos los artistas del producto
    $daoArtistaProducto = new Daoartista_producto(DDBB_NAME);
    $artista = $daoArtistaProducto->obtenerArtista_Producto($producto->__get("isbn_13"));
    $DaoArtista = new Daoartista(DDBB_NAME);
    $artista = $DaoArtista->obtener($artista->__get("artista_id"));
    //asignamos los artistas al producto
    $productoArtista = new ProductoArtista();
    $productoArtista->__set("isbn_13", $producto->__get("isbn_13"));
    $productoArtista->__set("portada", $producto->__get("portada"));
    $productoArtista->__set("nombre", $producto->__get("nombre"));
    $productoArtista->__set("coleccion", $producto->__get("coleccion"));
    $productoArtista->__set("numero", $producto->__get("numero"));
    $productoArtista->__set("tipo", $producto->__get("tipo"));
    $productoArtista->__set("formato", $producto->__get("formato"));
    $productoArtista->__set("paginas", $producto->__get("paginas"));
    $productoArtista->__set("subtipo", $producto->__get("subtipo"));
    $productoArtista->__set("editorial", $producto->__get("editorial"));
    $productoArtista->__set("anio_publicacion", $producto->__get("anio_publicacion"));
    $productoArtista->__set("sinopsis", $producto->__get("sinopsis"));
    $productoArtista->__set("precio", $producto->__get("precio"));
    $productoArtista->__set("stock", $producto->__get("stock"));
    $productoArtista->__set("nombreArtista", $artista->__get("nombre"));
    $productoArtista->__set("apellido1", $artista->__get("apellido1"));
    $productoArtista->__set("apellido2", $artista->__get("apellido2"));
    header('Content-Type: application/json');
    // var_dump($productoArtista);
    return $productoArtista;
}
