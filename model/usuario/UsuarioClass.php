<?php
//class Usuario
class Usuario
{
    private $id;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $birth;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
