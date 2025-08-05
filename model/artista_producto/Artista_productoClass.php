
<?php
//class Artista_producto
class Artista_producto implements JsonSerializable
{
    private $artista_id;
    private $isbn_13;
    private $trabajo;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
