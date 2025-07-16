<?php
require_once("./model/producto/ProductoPDO.php");
require_once("./model/artista_producto/Artista_productoPDO.php");
require_once("./model/detalleCompra/DetallecompraPDO.php");
class ProductoController
{
    private $tabla;
    private $tablaArtProd;
    private $tablaDetalleCompra;
    public function __construct()
    {
        $this->tabla = new Daoproducto(DDBB_NAME);
        $this->tablaArtProd = new Daoartista_producto(DDBB_NAME);
        $this->tablaDetalleCompra = new Daodetallecompra(DDBB_NAME);
    }


    public function view()
    {
        require_once("./view/crud/producto.php");
    }


    public function create()
    {
        if (isset($_POST["isbn_13"]) && isset($_FILES["portadaFile"]) && isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["formato"])) {
            try {
                // Validar los datos del formulario 
                $ProductoObjeto = new Producto();
                $ProductoObjeto->__set("isbn_13", $_POST["isbn_13"]);

                //Controlar que si no existe la imagen subida se inserte la foto ya guardada en la base de datos
                $imagenContenido = file_get_contents($_FILES["portadaFile"]['tmp_name']);
                $imagenContenido = base64_encode($imagenContenido);
                $ProductoObjeto->__set("portada", $imagenContenido);
                $ProductoObjeto->__set("nombre", $_POST["nombre"]);
                $ProductoObjeto->__set("coleccion", $_POST["coleccion"]);
                $ProductoObjeto->__set("numero", $_POST["numero"]);
                $ProductoObjeto->__set("tipo", $_POST["tipo"]);
                $ProductoObjeto->__set("subtipo", $_POST["subtipo"]);
                $ProductoObjeto->__set("formato", $_POST["formato"]);
                $ProductoObjeto->__set("paginas", $_POST["paginas"]);
                $ProductoObjeto->__set("editorial", $_POST["editorial"]);
                $ProductoObjeto->__set("anio_publicacion", $_POST["anio_publicacion"]);
                $ProductoObjeto->__set("sinopsis", $_POST["sinopsis"]);
                $ProductoObjeto->__set("precio", $_POST["precio"]);
                $ProductoObjeto->__set("stock", $_POST["stock"]);
                $ProductoObjeto->__set("ventas", 0);

                // Insertar el producto en la base de datos
                $this->tabla->insertar($ProductoObjeto);


                $productoArtistaObjeto = new Artista_producto();
                $productoArtistaObjeto->__set("artista_id", $_POST['autor']);
                $productoArtistaObjeto->__set("isbn_13", $_POST['isbn_13']);
                $productoArtistaObjeto->__set("trabajo", $_POST['trabajo']);

                $this->tablaArtProd->insertar($productoArtistaObjeto);
                $_SESSION['type'] = "exito";
                $_SESSION['mensaje'] = "insertado";
            } catch (\Throwable $th) {
                $_SESSION['type'] = "error";
                $_SESSION['mensaje'] = "noInsertado";
                throw $th;
            } finally {
                echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Producto&action=view';
            </script>";
            }
        } else {
            echo "Producto NO insertado correctamente";
        }
    }

    public function listar()
    {
        $this->tabla->listar();
        return $this->tabla->productos;
    }

    public function eliminar()
    {
        try {
            if (isset($_POST["check"])) {
                //Recorremos los valores del array $_POST["check"] y los mostramos
                foreach ($_POST["check"] as $key => $value) {
                    //Comprobamos si el producto tiene alguna compra asociada
                    if ($this->tablaDetalleCompra->existenComprasISBN($key)) {
                        
                        
                        //Eliminamos el dato de la base de datos
                        echo "ISBN:" . $key . "<br>";
                        echo "Autor:" . $_POST['autor_'][$key] . "<br>";
                        // echo $_POST["isbn_13_"][$key] ."<br>";
                        // borrar($artista_id, $isbn_13)
                        $this->tablaArtProd->borrar($_POST['autor_'][$key], $key);
                        $this->tabla->borrar($key);
                        $_SESSION['type'] = "exito";
                        $_SESSION['mensaje'] = "eliminado";
                    }else{
                        $_SESSION['type'] = "warning";
                        $_SESSION['mensaje'] = "comprasAsociadas";
                    }
                }
            } 
        } catch (\Throwable $th) {
            $_SESSION['type'] = "error";
            $_SESSION['mensaje'] = "noEliminado";
            throw $th;
        } finally {
            // echo "<script>
            //     localStorage.setItem('flash_msg', JSON.stringify({
            //         type: '" . ($_SESSION['type']) . "',
            //         message: '" . addslashes($_SESSION['mensaje']) . "'
            //     }));
            //     window.location.href = 'index.php?controller=Producto&action=view';
            // </script>";
        }
    }

    public function actualizar()
    {
        try {
            if (isset($_POST["check"])) {

                foreach ($_POST["check"] as $key => $value) {
                    $ProductoObjeto = new Producto();
                    $ProductoObjeto->__set("isbn_13", $_POST["isbn_13_"][$key]);
                    //Controlar que si no existe la imagen subida se inserte la foto ya guardada en la base de datos

                    if ($_FILES["portadaFile_"]['tmp_name'][$key]) {
                        //Convertir el archivo temporal en un BLOD
                        $imagenContenido = file_get_contents($_FILES["portadaFile_"]['tmp_name'][$key]);
                        $imagenContenido = base64_encode($imagenContenido);
                        $ProductoObjeto->__set("portada", $imagenContenido);
                        // echo "Se ha subido la imagen";
                    } else {
                        $producto = $this->tabla->obtener($_POST["isbn_13_"][$key]);
                        $ProductoObjeto->__set("portada", $producto->__get("portada"));
                        // echo "No se ha subido la imagen";
                    }
                    $ProductoObjeto->__set("nombre", $_POST["nombre_"][$key]);
                    $ProductoObjeto->__set("coleccion", $_POST["coleccion_"][$key]);
                    $ProductoObjeto->__set("numero", $_POST["numero_"][$key]);
                    $ProductoObjeto->__set("tipo", $_POST["tipo_"][$key]);
                    $ProductoObjeto->__set("subtipo", $_POST["subtipo_"][$key]);
                    $ProductoObjeto->__set("formato", $_POST["formato_"][$key]);
                    $ProductoObjeto->__set("paginas", $_POST["paginas_"][$key]);
                    $ProductoObjeto->__set("editorial", $_POST["editorial_"][$key]);
                    $ProductoObjeto->__set("anio_publicacion", $_POST["anio_publicacion_"][$key]);
                    $ProductoObjeto->__set("sinopsis", $_POST["sinopsis_"][$key]);
                    $ProductoObjeto->__set("precio", $_POST["precio_"][$key]);
                    $ProductoObjeto->__set("stock", $_POST["stock_"][$key]);
                    $this->tabla->actualizar($ProductoObjeto);

                    $productoArtistaObjeto = new Artista_producto();
                    $productoArtistaObjeto->__set("artista_id", $_POST['autor_'][$key]);
                    $productoArtistaObjeto->__set("isbn_13", $_POST['isbn_13_'][$key]);
                    $productoArtistaObjeto->__set("trabajo", $_POST['trabajo_'][$key]);
                    $this->tablaArtProd->actualizar($productoArtistaObjeto);
                }
                $_SESSION['type'] = "exito";
                $_SESSION['mensaje'] = "actualizado";
            }
        } catch (\Throwable $th) {
            $_SESSION['type'] = "error";
            $_SESSION['mensaje'] = "noActualizado";
            throw $th;
        } finally {
            echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Producto&action=view';
            </script>";
        }
    }

    public function getBestSellers($tipo)
    {

        $this->tabla->getBestSellers($tipo);
        $productos = $this->tabla->productos;
        echo json_encode($productos);
    }
}
