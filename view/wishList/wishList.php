<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("view/components/meta.php");
    if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] == false) {
        header("Location: index.php?controller=LogIn&action=view");
        exit();
    }

    ?>
    <title>Kvote Tienda de Comics</title>
</head>

<body>
    <?php
    require_once("view/components/header.php");
    require_once("view/components/subMenu.php");
    ?>
    <div class="containerMain">
        <main class="containerProductosWishList">
            <h1 class="lang" data-lang="titulo">Productos de <span><?php echo $_SESSION['username']; ?></span></h1>
        </main>
        <div id="content" class="cardSkeleton" style="height: 70rem;">
            <div class="skeleton image" style="width: 100%; height: 20%;"></div>
            <div class="skeleton image" style="width: 100%; height: 20%;"></div>
            <div class="skeleton image" style="width: 100%; height: 20%;"></div>
            <div class="skeleton image" style="width: 100%; height: 20%;"></div>
        </div>
    </div>
    <?php
    require_once("view/components/footer.php");
    ?>

    <script src="./assets/js/darkMode.js"></script>
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script type="module" src="./assets/js/lang.js"></script>
    <script type="module" src="./assets/js/wishListCargar.js"></script>
    <script type="module" src="./assets/js/politicaPrivacidad.js"></script>
    <!-- <script src="/js/carrusel.js"></script> -->
</body>

</html>