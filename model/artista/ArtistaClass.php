<?php
//class Artista
class Artista
{
    private $id;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $pais;
    private $fecha_nacimiento;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
