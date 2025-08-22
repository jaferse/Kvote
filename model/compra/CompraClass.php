<?php
//class Compra
class Compra implements JsonSerializable
{
    private $idCompra;
    private $idUsuario;
    private $fechaCompra;
    private $totalCompra;
    private $nTarjeta;
    private $idDireccion;
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
            'idCompra' => $this->idCompra,
            'idUsuario' => $this->idUsuario,
            'fechaCompra' => $this->fechaCompra,
            'totalCompra' => $this->totalCompra,
            'nTarjeta' => $this->nTarjeta,
            'idDireccion' => $this->idDireccion,
        ];
    }
}