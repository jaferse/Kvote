<?php
//class Pais
class Pais implements JsonSerializable
{
    private $codigo_iso;
    private $nombre;
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
