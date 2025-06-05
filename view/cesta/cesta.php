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

    <main class="containerCesta">
        <div class="productos"></div>
        <div class="resumen">
            <h2>Resumen cesta</h2>
            <div class="resumen__total">
                <p class="precioTotal"></p>
                <a class="comprar" href="">Comprar ahora</a>
            </div>
        </div>
    </main>

    <?php
    require_once("view/components/footer.php");
    ?>
    <script src="./assets/js/lang.js"></script>
    <script src="./assets/js/cesta.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
</body>

</html>