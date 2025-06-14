<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("view/components/meta.php");
    ?>
    <title>Kvote Tienda de Comics</title>
</head>

<body>
    <?php
    require_once("view/components/header.php");
    require_once("view/components/subMenu.php");
    ?>

    <main class="containerPedidos">
        <h1 class="lang" data-lang="titulo">Historial de Pedidos</h1>
        <div class="titulo">
            <p class="lang"  data-lang="fecha">Fecha</p>
            <p class="lang"  data-lang="idPedido">Id pedido</p>
            <p class="lang"  data-lang="precioTotal">Precio Total</p>
            <p class="lang"  data-lang="detallePedido">Detalle Pedido</p>
        </div>
    </main>

    <?php
    require_once("view/components/footer.php");
    ?>
    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <script src="./assets/js/historialPedidos.js"></script>
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
</body>

</html>