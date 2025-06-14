<?php
class ComentarioDetelle implements JsonSerializable
{
    private $id;
    private $usuario_id;
    private $producto_isbn_13;
    private $titulo;
    private $comentario;
    private $fecha;
    private $autor_nombre;
    private $autor_apellido1;
    private $autor_apellido2;
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
            'usuario_id' => $this->usuario_id,
            'producto_isbn_13' => $this->producto_isbn_13,
            'titulo' => $this->titulo,
            'comentario' => $this->comentario,
            'fecha' => $this->fecha,
            'autor_nombre' => $this->autor_nombre,
            'autor_apellido1' => $this->autor_apellido1,
            'autor_apellido2' => $this->autor_apellido2

        ];
    }
}
