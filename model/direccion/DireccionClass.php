<?php
class Direccion implements JsonSerializable
{
    private $id;
    private $paisISO;
    private $provinciaMatricula;
    private $codigo_postal;
    private $localidad;
    private $calle;
    private $numero;
    private $piso;
    private $puerta;
    private $usuario_id;
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
