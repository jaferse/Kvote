<?php
require_once("core/funcionesGenericas.php");

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
            require_once("model/direccion/DireccionPDO.php");
            require_once("model/pais/PaisPDO.php");
            require_once("model/provincia/ProvinciaPDO.php");
            require_once("model/localidad/LocalidadPDO.php");
            // require_once(");
            $compraDAO = new Daocompra(DDBB_NAME);
            $detalleCompraDAO = new Daodetallecompra(DDBB_NAME);
        }
    }

    public function view()
    {
        comprobarLogin();
        require_once("view/historialPedidos/historialPedidos.php");
    }

    public function listarPedidos()
    {
        $compraDAO = new Daocompra(DDBB_NAME);
        $detalleCompraDAO = new Daodetallecompra(DDBB_NAME);

        $compraDAO->obtenerPedidosUsuario($_SESSION['usernameId']);
        $historialPedidos = [];
        foreach ($compraDAO->compras as $key => $compra) {
            $idCompra = $compra->__get('idCompra');
            //Obtener las ultimas 4 cifras de la tarjeta de credito
            $ultimos4 = '*' . substr($compra->__get('nTarjeta'), -4);
            $compra->__set('nTarjeta', $ultimos4);
            $historialPedidos[$key]['compra'] = $compra;

            //Sacar direccion de la compra
            $compra->__set('idDireccion', $this->obtenerDireccion($compra->__get('idDireccion')));
            //Obtener detalle de la compra
            $detalleCompraDAO->obtenerDetalleCompra($idCompra);
            foreach ($detalleCompraDAO->detallecompras as $key2 => $productoUnitario) {
                $historialPedidos[$key]['detalle'][$productoUnitario->__get('isbn13')] = $productoUnitario;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($historialPedidos);
    }

    public function obtenerDireccion($id)
    {
        $direccionDAO = new Daodireccion(DDBB_NAME);
        $direccion = $direccionDAO->obtener($id);
        if ($direccion->__get('paisISO') != null
        && $direccion->__get('provinciaMatricula') != null
        && $direccion->__get('localidad') != null) {
            //Obtener pais
            $paisDAO = new Daopais(DDBB_NAME);
            $pais = $paisDAO->obtenerNombre($direccion->__get('paisISO'));
            $direccion->__set('pais', $pais);
            //Obtener provincia
            $provinciaDAO = new Daoprovincia(DDBB_NAME);
            $provincia = $provinciaDAO->obtenerNombre($direccion->__get('provinciaMatricula'), $direccion->__get('paisISO'));
            $direccion->__set('provincia', $provincia);
            //Obtener localidad
            $localidadDAO = new Daolocalidad(DDBB_NAME);
            $localidad = $localidadDAO->obtenerNombre($direccion->__get('localidad'), $direccion->__get('provinciaMatricula'), $direccion->__get('paisISO'));
            if (gettype($localidad) == 'array') {
                $direccion->__set('nombreLocalidad', $localidad['nombre']);
            } else {
                $direccion->__set('nombreLocalidad', $direccion->__get('localidad'));
            }
        }
        return $direccion;
    }
}
