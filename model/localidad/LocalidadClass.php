<?php
//class Localidad
class Localidad
{
    private $codigo;
    private $nombre;
    private $codigo_provincia;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
