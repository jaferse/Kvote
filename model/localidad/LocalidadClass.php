<?php
//class Localidad
class Localidad implements JsonSerializable
{
    private $codigo;
    private $nombre;
    private $codigo_provincia;
    private $codigo_pais;
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
