<?php
//class Disciplina
class Disciplina
{
    private $artista_id;
    private $disciplina;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
