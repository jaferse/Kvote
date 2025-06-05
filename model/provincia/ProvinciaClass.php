<?php
//class Provincia
class Provincia{
private $codigo_matricula;
private $nombre;
private $codigo_pais;
function __get($propiedad){
return $this->$propiedad;
}
function __set($propiedad, $valor){
$this->$propiedad = $valor;
}
}