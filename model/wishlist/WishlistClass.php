<?php
//class Wishlist
class Wishlist
{
    private $usuario_id;
    private $producto_isbn_13;
    private $fecha_agregado;
    private $rating;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
