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
    <main class="ContainerProducto">
        <article class="Producto">
            <div class="Producto__img">
                <img src="./assets/img/portadas/sinPortada.avif" alt="Portada">
            </div>
            <div class="Producto__info">
                <h2 class="Producto__info__titulo"></h2>
                <h3 class="Producto__info__autor"></h3>
                <p class="Producto__info__sinopsis"></p>
                <div class="Producto__info__caracteristicas">
                    <ul>
                        <li class="Producto__info__caracteristicas__publicacion"></li>
                        <li class="Producto__info__caracteristicas__paginas"></li>
                        <li class="Producto__info__caracteristicas__tipo"></li>
                        <li class="Producto__info__caracteristicas__subtipo"></li>
                        <li class="Producto__info__caracteristicas__formato"></li>
                        <li class="Producto__info__caracteristicas__editorial"></li>
                    </ul>
                </div>
                <div class="Producto__info__precioComprar">
                    <div class="Producto__info__precioComprar__precio">
                        <span class="Producto__info__precioComprar__precio__actual"></span>
                        <span class="Producto__info__precioComprar__precio__descuento"></span>
                        <!-- <button>Comprar</button> -->
                        <span class="Producto__info__precioComprar__precio__anterior"></span>
                    </div>
                    <div class="tooltip Producto__info__precioComprar__tooltip">
                        <button class="Producto__info__precioComprar__boton botonCesta">Añadir a la cesta</button>
                        <?php
                        // if (isset($_SESSION['mensajeError'])) {
                        //     echo "<span class='mensajeError'>" . $_SESSION['mensajeError'] . "</span>";
                        // }
                        ?>

                    </div>
                    <div class="tooltip Producto__info__precioWishlist__tooltip">
                        <button class="Producto__info__precioComprar__boton botonWishlist">Añadir a wishlist</button>
                        <?php
                        if (isset($_SESSION['mensajeErrorWishlist'])) {
                            echo "<span class='mensajeError'>" . $_SESSION['mensajeErrorWishlist'] . "</span>";
                            unset($_SESSION['mensajeErrorWishlist']);
                        }
                        ?>
                    </div>
                </div>


            </div>
        </article>

    </main>
    <?php
    require_once("view/components/footer.php");
    ?>

    <script src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <!-- <script src="/js/carrusel.js"></script> -->
    <script type="module" src="./assets/js/listaProductos.js"></script>
    <script type="module" src="./assets/js/cargarProducto.js"></script>
</body>

</html>