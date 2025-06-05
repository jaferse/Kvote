<?php
//class Detallecompra
class Detallecompra implements JsonSerializable
{
    private $idDetalle;
    private $idCompra;
    private $isbn13;
    private $unidades;
    private $precioUnitario;
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
        return [
            'idDetalle' => $this->idDetalle,
            'idCompra' => $this->idCompra,
            'isbn13' => $this->isbn13,
            'unidades' => $this->unidades,
            'precioUnitario' => $this->precioUnitario,
        ];
    }
}
