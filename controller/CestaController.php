<?php
class CestaController
{

    public function __construct()
    {
        session_start();
        require_once("model/compra/CompraPDO.php");
        require_once("model/detalleCompra/DetallecompraPDO.php");
    }

    function view()
    {
        require_once("view/cesta/cesta.php");
    }

    function comprar()
    {

        $compraDAO = new Daocompra(DDBB_NAME);
        $detalleCompraDAO = new Daodetallecompra(DDBB_NAME);
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data) {

            $idCompra = $this->generateUUIDv4();
            $compra = new Compra();
            $compra->__set("idCompra", $idCompra);
            $compra->__set("idUsuario", $_SESSION["usernameId"]);
            $totalCompra = 0;
            foreach ($data as $key => $producto) {
                $totalCompra = $totalCompra + ($producto["cantidad"] * $producto["producto"]["precio"]);
            }
            $compra->__set("totalCompra", $totalCompra);

            $compraDAO->insertar($compra);
            foreach ($data as $key => $producto) {
                $detalleCompra = new Detallecompra();
                $detalleCompra->__set("idCompra", $idCompra);
                $detalleCompra->__set("isbn13", $producto["producto"]["isbn_13"]);
                $detalleCompra->__set("unidades", $producto["cantidad"]);
                $detalleCompra->__set("precioUnitario", $producto["producto"]["precio"]);
                $detalleCompraDAO->insertar($detalleCompra);
            }

            $respuesta =[
                "status" => "success",
                "mensaje" => "Compra realizada con éxito",
                "idCompra" => $idCompra
            ];
        } else {
            $respuesta = [
                "status" => "error",
                "mensaje" => "No se recibieron datos"
            ];
        }

        echo json_encode($respuesta);
    }



    /**
     * Generates a UUID v4 according to RFC 4122
     *
     * @return string a UUID v4
     */
    function generateUUIDv4()
    {
        $data = random_bytes(16);
        // Establecer la versión a 0100 (UUID v4)
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Establecer el variant a 10xx
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
