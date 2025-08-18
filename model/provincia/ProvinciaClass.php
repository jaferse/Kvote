<?php
//class Provincia
class Provincia implements JsonSerializable
{
    private $codigo_matricula;
    private $nombre;
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
        return [
            'codigo_matricula' => $this->codigo_matricula,
            'codigo_pais' => $this->codigo_pais,
            'nombre' => $this->nombre
        ];
    }
}
