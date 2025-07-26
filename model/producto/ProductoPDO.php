<?php
//Revisar la situación del path
require_once("./core/DBClass.php");
require_once("ProductoClass.php");
class Daoproducto extends DB
{
    private $productosPagina = 8; //Número de productos por página
    public $productos = array();
    /**
     * Constructor de la clase. Llama al constructor de la clase DB.
     * @param string $base nombre de la base de datos
     */
    function __construct($base)
    {
        parent::__construct($base); //Llama al constructor de la clase DB

    }
    public function listar()
    {
        $consulta = 'SELECT * FROM producto';
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $prod = new Producto(); //creamos un objeto de la entidad situacion
            $prod->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("portada", $fila['portada']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("coleccion", $fila['coleccion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("tipo", $fila['tipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("formato", $fila['formato']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("paginas", $fila['paginas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("subtipo", $fila['subtipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("editorial", $fila['editorial']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("anio_publicacion", $fila['anio_publicacion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("sinopsis", $fila['sinopsis']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("precio", $fila['precio']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("stock", $fila['stock']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("ventas", $fila['ventas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->productos[] = $prod; //Guardamos ese objeto en el array de objetos prod
        }
    }
    public function listarComic()
    {
        $consulta = 'SELECT * FROM producto WHERE 
                        tipo="Americano" 
                        OR tipo="Manga"
                        OR tipo="Manhwa"
                        OR tipo="Europeo"
                        OR tipo="Indie"
                        OR tipo="Webcomic"
                        LIMIT  ' . ($_GET['page'] - 1) * $this->productosPagina . ',' . $this->productosPagina;
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $prod = new Producto(); //creamos un objeto de la entidad situacion
            $prod->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("portada", $fila['portada']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("coleccion", $fila['coleccion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("tipo", $fila['tipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("formato", $fila['formato']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("paginas", $fila['paginas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("subtipo", $fila['subtipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("editorial", $fila['editorial']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("anio_publicacion", $fila['anio_publicacion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("sinopsis", $fila['sinopsis']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("precio", $fila['precio']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("stock", $fila['stock']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("ventas", $fila['ventas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->productos[] = $prod; //Guardamos ese objeto en el array de objetos prod
        }
    }
    public function listarLibros()
    {
        $consulta = 'SELECT * FROM producto WHERE 
                        tipo="Novela" 
                        OR tipo="No Ficción"
                        OR tipo="Antología"
                        OR tipo="Otro"
                        LIMIT  ' . ($_GET['page'] - 1) * $this->productosPagina . ',' . $this->productosPagina;
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $prod = new Producto(); //creamos un objeto de la entidad situacion
            $prod->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("portada", $fila['portada']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("coleccion", $fila['coleccion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("tipo", $fila['tipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("formato", $fila['formato']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("paginas", $fila['paginas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("subtipo", $fila['subtipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("editorial", $fila['editorial']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("anio_publicacion", $fila['anio_publicacion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("sinopsis", $fila['sinopsis']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("precio", $fila['precio']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("stock", $fila['stock']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("ventas", $fila['ventas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->productos[] = $prod; //Guardamos ese objeto en el array de objetos prod
        }
    }
    //Meter dato nuevo
    public function listarNovedades()
    {
        $_GET['page']; //Forzamos a que la paginación empiece desde la primera página
        $consulta = 'SELECT * FROM producto ORDER BY anio_publicacion DESC LIMIT  ' . ($_GET['page'] - 1) * $this->productosPagina . ',' . $this->productosPagina;
        $this->consultaDatos($consulta);
        foreach ($this->filas as $fila) {
            $prod = new Producto(); //creamos un objeto de la entidad situacion
            $prod->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("portada", $fila['portada']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("coleccion", $fila['coleccion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("tipo", $fila['tipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("formato", $fila['formato']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("paginas", $fila['paginas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("subtipo", $fila['subtipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("editorial", $fila['editorial']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("anio_publicacion", $fila['anio_publicacion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("sinopsis", $fila['sinopsis']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("precio", $fila['precio']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("stock", $fila['stock']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("ventas", $fila['ventas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->productos[] = $prod; //Guardamos ese objeto en el array de objetos prod

        }
    }
    public function listarPorAutor($nombre_autor)
    {
        $_GET['page']; //Forzamos a que la paginación empiece desde la primera página
        $partes = explode("-", $nombre_autor);
        $consulta = 'SELECT * FROM producto WHERE isbn_13 IN 
            (SELECT ISBN_13 FROM artista_producto WHERE artista_id IN 
                (SELECT id FROM artista WHERE nombre = :nombre AND apellido1= :apellido1 AND apellido2= :apellido2)
            ) 
        ORDER BY anio_publicacion DESC LIMIT  ' . ($_GET['page'] - 1) * $this->productosPagina . ',' . $this->productosPagina;
        $param = array();
        $param[":nombre"] = $partes[0];
        $param[":apellido1"] = $partes[1];
        $param[":apellido2"] = $partes[2];
        $this->consultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $prod = new Producto(); //creamos un objeto de la entidad situacion
            $prod->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("portada", $fila['portada']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("coleccion", $fila['coleccion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("tipo", $fila['tipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("formato", $fila['formato']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("paginas", $fila['paginas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("subtipo", $fila['subtipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("editorial", $fila['editorial']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("anio_publicacion", $fila['anio_publicacion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("sinopsis", $fila['sinopsis']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("precio", $fila['precio']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("stock", $fila['stock']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("ventas", $fila['ventas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->productos[] = $prod; //Guardamos ese objeto en el array de objetos prod
        }
    }
    /**
     * Obtiene una situacion de la base de datos por su Id.
     *
     * @param int $Id El id de la situacion a obtener.
     * @return Situacion El objeto Situacion correspondiente al Id proporcionado
     * Si no se encuentra, se devuelve un objeto Situacion vacío.
     */
    public function obtener($isbn_13)
    {
        $consulta = "SELECT * FROM producto WHERE isbn_13= :isbn_13 ";
        $param = array();
        $param[":isbn_13"] = $isbn_13;
        $this->consultaDatos($consulta, $param);
        $prod = new Producto(); //creamos un objeto de la entidad Producto
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];
            $prod->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("portada", $fila['portada']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("coleccion", $fila['coleccion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("tipo", $fila['tipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("formato", $fila['formato']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("paginas", $fila['paginas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("subtipo", $fila['subtipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("editorial", $fila['editorial']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("anio_publicacion", $fila['anio_publicacion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("sinopsis", $fila['sinopsis']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("precio", $fila['precio']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("stock", $fila['stock']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("ventas", $fila['ventas']); //Le asignamos a las propiedades del objetos los campos de esa fila
        }
        return $prod;
    }
    /**
     * Inserta una situacion en la base de datos
     * @param Situacion $prod El objeto a insertar
     * @return void
     */
    public function insertar($prod)
    {
        //Se introduce un objeto por parametro que se insertará
        $consulta = "INSERT INTO producto (
                isbn_13, portada, nombre, coleccion, numero, tipo, formato, paginas, subtipo,
                editorial, anio_publicacion, sinopsis, precio, stock, ventas
            ) VALUES (
                :isbn_13, :portada, :nombre, :coleccion, :numero, :tipo, :formato, :paginas, :subtipo,
                :editorial, :anio_publicacion, :sinopsis, :precio, :stock, :ventas
            )";

        $param = array();
        $param[":isbn_13"] = $prod->__get("isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":portada"] = $prod->__get("portada"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $prod->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":coleccion"] = $prod->__get("coleccion"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":numero"] = $prod->__get("numero"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":tipo"] = $prod->__get("tipo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":formato"] = $prod->__get("formato"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":paginas"] = $prod->__get("paginas"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":subtipo"] = $prod->__get("subtipo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":editorial"] = $prod->__get("editorial"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":anio_publicacion"] = $prod->__get("anio_publicacion"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":sinopsis"] = $prod->__get("sinopsis"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":precio"] = $prod->__get("precio"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":stock"] = $prod->__get("stock"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":ventas"] = $prod->__get("ventas"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    /**;
     * Actualiza una situacion en la base de datos;
     * @param Producto prod El objeto a actualizar;
     * @return void;
     */
    public function actualizar($prod)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " UPDATE producto SET portada= :portada, nombre= :nombre, coleccion= :coleccion, numero= :numero, tipo= :tipo, formato= :formato, paginas=:paginas, subtipo=:subtipo, editorial= :editorial, anio_publicacion= :anio_publicacion, sinopsis= :sinopsis, precio= :precio, stock= :stock WHERE isbn_13= :isbn_13";
        $param = array();
        $param[":isbn_13"] = $prod->__get("isbn_13"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":portada"] = $prod->__get("portada"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":nombre"] = $prod->__get("nombre"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":coleccion"] = $prod->__get("coleccion"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":numero"] = $prod->__get("numero"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":tipo"] = $prod->__get("tipo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":formato"] = $prod->__get("formato"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":paginas"] = $prod->__get("paginas"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":subtipo"] = $prod->__get("subtipo"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":editorial"] = $prod->__get("editorial"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":anio_publicacion"] = $prod->__get("anio_publicacion"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":sinopsis"] = $prod->__get("sinopsis"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":precio"] = $prod->__get("precio"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $param[":stock"] = $prod->__get("stock"); //Le asignamos a las propiedades del objetos los campos de esa fila
        $this->consultaSimple($consulta, $param);
    }
    public function actualizarVentasProducto($isbn_13, $ventas)
    {
        $consulta = " UPDATE producto SET ventas= :ventas WHERE isbn_13= :isbn_13";
        $param = array();
        $param[":isbn_13"] = $isbn_13;
        $param[":ventas"] = $ventas;
        $this->consultaSimple($consulta, $param);
    }
    public function consultarStock($isbn_13)
    {
        $consulta = "SELECT stock FROM producto WHERE isbn_13 = :isbn_13";
        $param = array();
        $param[":isbn_13"] = $isbn_13;
        $this->consultaDatos($consulta, $param);
        return $this->filas[0]['stock'];
    }
    public function actualizarStockProducto($isbn_13, $cantidad)
    {
        $stock = $this->consultarStock($isbn_13);
        if ($stock >= $cantidad) {
            $stock = $stock - $cantidad;
            $consulta = " UPDATE producto SET stock= :stock WHERE isbn_13= :isbn_13";
            $param = array();
            $param[":isbn_13"] = $isbn_13;
            $param[":stock"] = $stock;
            $this->consultaSimple($consulta, $param);
        }
    }
    /**
     * Borra una situacion en la base de datos
     * @param int El id de la situacion a borrar
     * @return void
     */
    public function borrar($isbn_13)
    { //Se introduce un objeto por parametro que se insertará
        $consulta = " DELETE FROM producto WHERE isbn_13= :isbn_13";
        $param = array();
        $param[":isbn_13"] = $isbn_13;
        $this->consultaSimple($consulta, $param);
    }

    public function getEnum($columna)
    {
        $consulta = "SELECT COLUMN_TYPE
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_NAME = :tabla
                    AND COLUMN_NAME = :columna
                    AND TABLE_SCHEMA = :schema";
        $param = array();
        $param[":tabla"] = "producto";
        $param[":columna"] = $columna;
        $param[":schema"] = "kvote_db";
        $this->consultaDatos($consulta, $param);

        $dato = str_replace("enum(", "", $this->filas[0]['COLUMN_TYPE']);
        $dato = str_replace(")", "", $dato);
        $dato = str_replace("'", "", $dato);
        $dato = explode(",", $dato);
        return $dato;
    }

    public function getBestSellers($type)
    {
        $consulta = "SELECT * FROM `producto` WHERE `tipo` ";
        if ($type == "comic") {
            $consulta .= "IN ('Americano', 'Manga', 'Manhwa', 'Europeo', 'Indie', 'Webcomic') ";
        } else {
            $consulta .= "IN ('Novela', 'No Ficción', 'Antología', 'Otro') ";
        }
        $consulta .= " ORDER BY `Ventas` DESC LIMIT 3; ";

        $this->consultaDatos($consulta);

        foreach ($this->filas as $fila) {
            $prod = new Producto(); //creamos un objeto de la entidad situacion
            $prod->__set("isbn_13", $fila['isbn_13']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("portada", $fila['portada']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("nombre", $fila['nombre']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("coleccion", $fila['coleccion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("numero", $fila['numero']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("tipo", $fila['tipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("formato", $fila['formato']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("paginas", $fila['paginas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("subtipo", $fila['subtipo']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("editorial", $fila['editorial']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("anio_publicacion", $fila['anio_publicacion']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("sinopsis", $fila['sinopsis']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("precio", $fila['precio']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("stock", $fila['stock']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $prod->__set("ventas", $fila['ventas']); //Le asignamos a las propiedades del objetos los campos de esa fila
            $this->productos[] = $prod; //Guardamos ese objeto en el array de objetos prod
        }
    }
    public function numeroProductos($tipo = '')
    {
        $consulta = "SELECT COUNT(*) as total FROM producto WHERE 1 ";
        if ($tipo == 'comic') {
            $consulta .= "AND tipo IN ('Americano', 'Manga', 'Manhwa', 'Europeo', 'Indie', 'Webcomic') ";
        } else if ($tipo == 'libro') {
            $consulta .= "AND tipo IN ('Novela', 'No Ficción', 'Antología', 'Otro') ";
        }
        $this->consultaDatos($consulta);
        return $this->filas[0]['total'];
    }
    public function numeroProductosFiltro($campo, $valor)
    {
        $consulta = "SELECT COUNT(*) as total FROM producto WHERE 1 ";
        $param = array();
        if ($campo = 'Autor') {
            $consulta .= " AND isbn_13 IN 
            (SELECT ISBN_13 FROM artista_producto WHERE artista_id IN 
                (SELECT id FROM artista WHERE nombre = :nombre AND apellido1= :apellido1 AND apellido2= :apellido2)
            )";
            $partes = explode("-", $valor);
            $param[":nombre"] = $partes[0];
            $param[":apellido1"] = $partes[1];
            $param[":apellido2"] = $partes[2];
        } else {
            $consulta .= " AND $campo LIKE :valor";
            $param[":valor"] = $valor;
        }
        // echo $consulta;
        $this->consultaDatos($consulta, $param);
        return $this->filas[0]['total'];
    }
    public function getProductoPaginas()
    {
        return $this->productosPagina;
    }
}
