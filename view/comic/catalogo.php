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
    <div class="containerMain">
        <main class="container">
            <div class="containerProductos"></div>
        </main>
        <div id="content" class="cardSkeleton" style="display: grid;grid-template-columns: repeat(4, 1fr);column-gap: 4rem; row-gap:3rem;min-height: 80rem;">
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
            <div class="skeleton image" style="width: 100%; height: 100%; border: 1px solid transparent; border-radius: 18px"></div>
        </div>
    </div>
    <!-- Footer -->
    <?php
    require_once("view/components/footer.php");
    ?>

    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script type="module" src="./assets/js/productos.js"></script>

</body>

</html>