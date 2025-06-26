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
        <h1 class="lang" data-lang="titulo"></h1>
        <div class="productos"></div>
        <div class="resumen">
            <h2 class="titulo lang" data-lang="resCesta">Resumen cesta</h2>
            <div class="resumen__total">
                <p class="precioTotal"><span></span></p>
                <div class="enlaceBotonSmall">
                    <a class="comprar lang" data-lang="finalizarCompra" href=""></a>
                </div>
            </div>
        </div>
    </main>

    <?php
    require_once("view/components/footer.php");
    ?>
    <script type="module" src="./assets/js/lang.js"></script>
    <script type="module" src="./assets/js/cesta.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
</body>

</html>