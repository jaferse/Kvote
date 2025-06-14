<?php
//class Usuario
class Usuario implements JsonSerializable
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

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'birth' => $this->birth
        ];
    }
}
