<?php
//class Comentario
class Comentario
{
    private $id;
    private $usuario_id;
    private $producto_isbn_13;
    private $comentario;
    private $fecha;
    function __get($propiedad)
    {
        return $this->$propiedad;
    }
    function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
?>