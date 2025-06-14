<!DOCTYPE html>
<html lang="es">

<head>
    <?php

    require_once("view/components/meta.php");
    ?>
    <title>Comics</title>
</head>

<body>
    <?php
    require_once("view/components/header.php");
    require_once("view/components/subMenu.php");
    ?>
    <main class="containerProductos">
    </main>
    <!-- Footer -->
    <?php
    require_once("view/components/footer.php");
    ?>

    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script type="module" src="./assets/js/listaProductos.js"></script>
    <script type="module" src="./assets/js/productos.js"></script>

</body>

</html>