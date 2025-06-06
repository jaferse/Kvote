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
    <main class="containerProductosWishList">
        <h1>Productos de <?php echo $_SESSION['username']; ?></h1>
    </main>



    <?php
    require_once("view/components/footer.php");
    ?>


    <script src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script src="./assets/js/wishListCargar.js"></script>
    <!-- <script src="/js/carrusel.js"></script> -->
    <!-- <script type="module" src="./assets/js/listaProductos.js"></script>
    <script type="module" src="./assets/js/cargarProducto.js"></script> -->
</body>

</html>