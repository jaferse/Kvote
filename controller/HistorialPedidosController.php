<?php

class HistorialPedidosController
{
    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['logueado']) && $_SESSION['logueado'] == false) {
            header("Location: index.php?controller=LogIn&action=view");
        } else {
            require_once("model/compra/CompraPDO.php");
            require_once("model/detalleCompra/DetallecompraPDO.php");
            $compraDAO = new Daocompra(DDBB_NAME);
            $detalleCompraDAO = new Daodetallecompra(DDBB_NAME);
        }
    }

    public function view()
    {
        require_once("view/historialPedidos/historialPedidos.php");
    }

    public function listarPedidos()
    {
        // echo $_SESSION['username'];
        // echo $_SESSION['usernameId'];
        $compraDAO = new Daocompra(DDBB_NAME);
        $detalleCompraDAO = new Daodetallecompra(DDBB_NAME);

        $compraDAO->obtenerPedidosUsuario($_SESSION['usernameId']);
        $historialPedidos=[];
        foreach ($compraDAO->compras as $key => $compra) {
            // var_dump($compra);
            $idCompra=$compra->__get('idCompra');
            $historialPedidos[$key]['compra'] = $compra;
            //Obtener detalle de la compra
            $detalleCompraDAO->obtenerDetalleCompra($idCompra);
            foreach ($detalleCompraDAO->detallecompras as $key2 => $productoUnitario) {
                 $historialPedidos[$key]['detalle'][$productoUnitario->__get('isbn13')] = $productoUnitario;
            }
            
        }
        // var_dump($historialPedidos);
        header('Content-Type: application/json');
        echo json_encode($historialPedidos);
    }
}
