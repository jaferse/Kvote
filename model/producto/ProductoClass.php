<?php
//class Producto
class Producto implements JsonSerializable
{
    private $isbn_13;
    private $portada;
    private $nombre;
    private $coleccion;
    private $numero;
    private $tipo;
    private $formato;
    private $paginas;
    private $subtipo;
    private $editorial;
    private $anio_publicacion;
    private $sinopsis;
    private $precio;
    private $stock;
    private $ventas;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
 // Método requerido por JsonSerializable
 public function jsonSerialize(): mixed {
    return [
        'isbn_13' => $this->isbn_13,
        'portada' => $this->portada,
        'nombre' => $this->nombre,
        'coleccion' => $this->coleccion,
        'numero' => $this->numero,
        'tipo' => $this->tipo,
        'formato' => $this->formato,
        'paginas' => $this->paginas,
        'subtipo' => $this->subtipo,
        'editorial' => $this->editorial,
        'anio_publicacion' => $this->anio_publicacion,
        'sinopsis' => $this->sinopsis,
        'precio' => $this->precio,
        'stock' => $this->stock,
        'ventas' => $this->ventas,
    ];
}
}
