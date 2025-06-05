<?php
//class Tarjeta
class Tarjeta
{
    private $numero_tarjeta;
    private $nombre_titular;
    private $emisor_tarjeta;
    private $cvv_cvc;
    private $tipo_tarjeta;
    private $fecha_caducidad;
    private $usuario_id;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
