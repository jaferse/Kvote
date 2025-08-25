<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("./model/producto/ProductoPDO.php");
require_once("./model/artista_producto/Artista_productoPDO.php");
require_once("./model/detalleCompra/DetallecompraPDO.php");
class ProductoController
{
    private $tabla;
    private $tablaArtProd;
    private $tablaDetalleCompra;
    public $productosPagina = 10;
    public function __construct()
    {
        $this->tabla = new Daoproducto(DDBB_NAME);
        $this->tablaArtProd = new Daoartista_producto(DDBB_NAME);
        $this->tablaDetalleCompra = new Daodetallecompra(DDBB_NAME);
    }


    /**
     * Muestra la vista de productos, que incluye una lista de los productos,
     * un formulario para filtrarlos y un enlace para crear uno nuevo.
     *
     * @return void
     */
    public function view()
    {
        if ($_SESSION['admin'] == false) {
            header("Location: index.php?controller=Index&action=view");
        }
        require_once("./view/crud/producto.php");
    }


    /**
     * Inserta un producto en la base de datos.
     *
     * La función es llamada desde el formulario de creación de productos.
     * La función valida los datos del formulario y si son correctos, crea un objeto Producto con los datos del formulario y lo inserta en la base de datos.
     * Si el producto es insertado correctamente, se muestra un mensaje de éxito y se redirige al usuario a la vista de productos.
     * Si hay algún error, se muestra un mensaje de error y se redirige al usuario a la vista de productos.
     */
    public function create()
    {
        try {
            // $hoy = date("Y-m-d");
            if (
                isset($_POST["isbn_13"]) &&
                isset($_FILES["portadaFile"]) &&
                isset($_POST["nombre"]) &&
                isset($_POST["coleccion"]) &&
                isset($_POST["numero"]) &&
                isset($_POST["tipo"]) &&
                isset($_POST["subtipo"]) &&
                isset($_POST["formato"]) &&
                isset($_POST["paginas"]) &&
                isset($_POST["editorial"]) &&
                isset($_POST["anio_publicacion"]) &&
                isset($_POST["sinopsis"]) &&
                isset($_POST["precio"]) &&
                isset($_POST["stock"])
            ) {
                $_POST["precio"] = str_replace(',', '.', $_POST["precio"]);
                if (
                    $this->isbnCorrecto($_POST["isbn_13"]) &&
                    $this->extensionCorrecta($_FILES["portadaFile"]["type"]) &&
                    $this->tamannoCorrectoImg($_FILES["portadaFile"]['size']) &&
                    $this->maxLenght($_POST["nombre"], 50) &&
                    $this->maxLenght($_POST["coleccion"], 45) &&
                    $this->maxLenght($_POST["editorial"], 45) &&
                    $this->maxLenght($_POST["numero"], 5) &&
                    $this->maxLenght($_POST["paginas"], 5) &&
                    $this->maxLenght($_POST["editorial"], 45) &&
                    $this->maxLenght($_POST["stock"], 10) &&
                    // $_POST["anio_publicacion"] <= $hoy &&
                    $this->esDecimalPositivoEnRango($_POST["precio"])
                ) {
                    // Validar los datos del formulario 
                    $ProductoObjeto = new Producto();
                    $ProductoObjeto->__set("isbn_13", $_POST["isbn_13"]);

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
                }
            } else {
                $_SESSION['type'] = "error";
                $_SESSION['mensaje'] = "1000";
            }
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
    }

    /**
     * Comprueba si un valor es un número decimal positivo en el rango 0-9999999.99
     * 
     * @param mixed $valor El valor a comprobar
     * @return bool True si el valor cumple la condición, false si no
     */
    function esDecimalPositivoEnRango($valor)
    {

        // Validar que sea numérico
        if (!is_numeric($valor)) {
            return false; // No es un número válido
        }

        $num = (float) $valor;

        $max = 9999999.99;
        $min = 0;

        // Devuelve true si está en rango, false si no
        return ($num >= $min && $num <= $max);
    }
    /**
     * Comprueba si el valor de $get no supera la longitud de $max
     *
     * @param string $get valor a comprobar
     * @param int $max longitud máxima permitida
     *
     * @return bool true si no supera la longitud, false en caso contrario
     */
    public function maxLenght($get, $max)
    {
        if (strlen($get) > $max) {
            $_SESSION['type'] = "error";
            $_SESSION['mensaje'] = "1000";
            return false;
        }
        return true;
    }

    /**
     * Comprueba si el archivo de portada subido es mayor o igual a 15MB.
     * Si es true, se guardan los datos en la sesion para mostrar el mensaje
     * de error correspondiente.
     *
     * @return bool true si el archivo es menor a 15MB, false en caso contrario
     */
    public function tamannoCorrectoImg($sizeFile)
    {
        if ($sizeFile >= 16777215) {
            $_SESSION['type'] = "error";
            $_SESSION['mensaje'] = "1005";
            return false;
        }
        return true;
    }

    /**
     * Verifica si el tipo de archivo de la portada es permitido
     *
     * @return bool
     */
    public function extensionCorrecta($typeFile)
    {
        $tiposPermitidos = [
            "image/png",
            "image/jpeg",
            "image/webp",
            "image/gif",
            "image/bmp",
            "image/svg+xml",
            "image/x-icon"
        ];

        if (!in_array($typeFile, $tiposPermitidos)) {
            $_SESSION['type'] = "error";
            $_SESSION['mensaje'] = "1004";
            return false;
        }
        return true;
    }

    /**
     * Comprueba si el isbn_13 tiene una longitud de 13 caracteres.
     * Si no es así, guarda un mensaje de error en $_SESSION y devuelve false.
     * En caso contrario, devuelve true.
     * @return bool true si el isbn tiene 13 caracteres, false en caso contrario
     */
    public function isbnCorrecto($isbn)
    {
        if (strlen($isbn) !== 13) {
            $_SESSION['type'] = "error";
            $_SESSION['mensaje'] = "1003";
            return false;
        }
        return true;
    }

    /**
     * Lista todos los productos.
     * 
     * @return array Un array de objetos Producto
     */
    public function listar()
    {
        $this->tabla->listar();
        return $this->tabla->productos;
    }

    /**
     * Devuelve los productos de la base de datos en formato json paginados.
     * 
     * La cantidad de productos por página se encuentra en la variable $productosPagina.
     * La página actual se encuentra en el parámetro $_GET['page'].
     * @return json Un json con los productos de la base de datos
     */
    public function obtenerProductosPaginado()
    {
        $this->tabla->listarPaginacion($_GET['page'], $this->productosPagina);
        $respuesta = $this->tabla->productos;
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    /**
     * Elimina los productos seleccionados en la vista de lista de productos
     * 
     * Verifica si el producto tiene compras asociadas, en caso de tenerlas
     * no se elimina y se muestra un mensaje de warning.
     * En caso de no tener compras se elimina y se muestra un mensaje de exito.
     * En caso de error se muestra un mensaje de error.
     * 
     * @throws \Throwable En caso de error al eliminar el producto
     * @return void
     */
    public function eliminar()
    {
        try {
            if (isset($_POST["check"])) {
                //Recorremos los valores del array $_POST["check"] y los mostramos
                foreach ($_POST["check"] as $key => $value) {
                    //Comprobamos si el producto tiene alguna compra asociada
                    if (!$this->tablaDetalleCompra->existenComprasISBN($key)) {
                        //Eliminamos el dato de la base de datos
                        $this->tablaArtProd->borrar($_POST['autor_'][$key], $key);
                        $this->tabla->borrar($key);
                        $_SESSION['type'] = "exito";
                        $_SESSION['mensaje'] = "eliminado";
                    } else {
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
            echo "<script>
                localStorage.setItem('flash_msg', JSON.stringify({
                    type: '" . ($_SESSION['type']) . "',
                    message: '" . addslashes($_SESSION['mensaje']) . "'
                }));
                window.location.href = 'index.php?controller=Producto&action=view';
            </script>";
        }
    }

    public function actualizar()
    {
        // $hoy = date("Y-m-d");
        try {
            if (isset($_POST["check"])) {

                foreach ($_POST["check"] as $key => $value) {

                    //sustituimos las comas por puntos en el precio
                    $_POST["precio_"][$key] = str_replace(',', '.', $_POST["precio_"][$key]);
                    $ProductoObjeto = new Producto();

                    if ($_FILES["portadaFile_"]['tmp_name'][$key]) {
                        //Convertir el archivo temporal en un BLOD
                        $imagenContenido = file_get_contents($_FILES["portadaFile_"]['tmp_name'][$key]);
                        $imagenContenido = base64_encode($imagenContenido);
                        $ProductoObjeto->__set("portada", $imagenContenido);
                    } else {
                        $producto = $this->tabla->obtener($_POST["isbn_13_"][$key]);
                        $ProductoObjeto->__set("portada", $producto->__get("portada"));
                    }
                    if (
                        $this->isbnCorrecto($_POST["isbn_13_"][$key]) &&
                        // (isset($_FILES["portadaFile"][$key]) && $this->extensionCorrecta($_FILES["portadaFile"]['type'][$key]) &&
                        //     $this->tamannoCorrectoImg($_FILES["portadaFile"]['size'][$key]))  &&
                        $this->maxLenght($_POST["nombre_"][$key], 50) &&
                        $this->maxLenght($_POST["coleccion_"][$key], 45) &&
                        $this->maxLenght($_POST["editorial_"][$key], 45) &&
                        $this->maxLenght($_POST["numero_"][$key], 5) &&
                        $this->maxLenght($_POST["paginas_"][$key], 5) &&
                        $this->maxLenght($_POST["editorial_"][$key], 45) &&
                        $this->maxLenght($_POST["stock_"][$key], 10) &&
                        // $_POST["anio_publicacion_"][$key] <= $hoy &&
                        $this->esDecimalPositivoEnRango($_POST["precio_"][$key])
                    ) {
                        $ProductoObjeto->__set("isbn_13", $_POST["isbn_13_"][$key]);
                        //Controlar que si no existe la imagen subida se inserte la foto ya guardada en la base de datos


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
                        if ("existe") {
                            $this->tablaArtProd->actualizar($productoArtistaObjeto);
                        }
                        $_SESSION['type'] = "exito";
                        $_SESSION['mensaje'] = "actualizado";
                    } else {
                        $_SESSION['type'] = "error";
                        $_SESSION['mensaje'] = "noActualizado";
                    }
                }
            } else {
                $_SESSION['type'] = "error";
                $_SESSION['mensaje'] = "noActualizado";
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

    public function getArtista()
    {
        $isbn_13 = $_GET['parametro'];
        $respuesta = $this->tablaArtProd->obtenerArtista_Producto($isbn_13);
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    public function getBestSellers($tipo)
    {
        $this->tabla->getBestSellers($tipo);
        $productos = $this->tabla->productos;
        echo json_encode($productos);
    }
    public function obtenerNumeroElementos()
    {
        $respuesta = $this->tabla->numeroProductos();
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function elementosPorPagina()
    {
        header('Content-Type: application/json');
        echo json_encode($this->productosPagina);
    }

    public function obtenerTrabajos()
    {
        $respuesta = $this->tablaArtProd->getEnum("trabajo");
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function listarTipos()
    {
        $respuesta = $this->tabla->getEnum("tipo");
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    public function listarFormatos()
    {
        $respuesta = $this->tabla->getEnum("formato");
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    public function listarGeneros()
    {
        $respuesta = $this->tabla->getEnum("subtipo");
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
