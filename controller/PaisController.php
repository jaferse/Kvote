<?php
require_once("./model/pais/PaisPDO.php");
class PaisController
{
    private $tabla;
    public function __construct()
    {
        $this->tabla = new Daopais(DDBB_NAME);
    }

    public function listarPaises()
    {
        $this->tabla->listar();
        header('Content-Type: application/json');
        echo json_encode($this->tabla->paiss);
    }
    public function obtenerPais()
    {
       $pais= $this->tabla->obtener($_GET['parametro']);
        header('Content-Type: application/json');
        echo json_encode($pais);
        // return $this->tabla->paiss;
    }
}
