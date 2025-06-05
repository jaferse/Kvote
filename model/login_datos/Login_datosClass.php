<?php
//class Login_datos
class Login_datos{
private $username;
private $email;
private $password;
private $usuario_id;
private $admin=false;
function __get($propiedad){
return $this->$propiedad;
}
function __set($propiedad, $valor){
$this->$propiedad = $valor;
}
}