<?php
//class Pais
class Pais
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
}
