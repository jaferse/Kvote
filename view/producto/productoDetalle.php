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
                        <li class="Producto__info__caracteristicas__publicacion lang"></li>
                        <li class="Producto__info__caracteristicas__paginas"></li>
                        <li class="Producto__info__caracteristicas__tipo lang"></li>
                        <li class="Producto__info__caracteristicas__subtipo lang"></li>
                        <li class="Producto__info__caracteristicas__formato lang"></li>
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
                        <button class="Producto__info__precioComprar__boton botonCesta btnVerdePrimario">Añadir a la cesta</button>
                        <?php
                        // if (isset($_SESSION['mensajeError'])) {
                        //     echo "<span class='mensajeError'>" . $_SESSION['mensajeError'] . "</span>";
                        // }
                        ?>

                    </div>
                    <div class="tooltip Producto__info__precioWishlist__tooltip">
                        <button class="Producto__info__precioComprar__boton botonWishlist btnVerdeSecundario">Añadir a wishlist</button>
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
        <article class="Producto__comentarios">
            <h2 class="Producto__comentarios__titulo lang" data-lang="titulo">Comentarios</h2>

            <?php
            if (isset($_SESSION['username'])) {
                echo "<form method='post' class='Producto__comentarios__formulario'>";
                echo "<div class='Producto__comentarios__formulario__titulo'>";
                echo "<input class='Producto__comentarios__formulario__titulo__input lang' data-lang='tituloComentario' name='titulo' id='titulo' maxlength='100' placeholder=''></input>";
                echo "</div>";
                echo "<div>";
                echo "    <textarea class='Producto__comentarios__formulario__texto lang' data-lang='escribeComentario' name='comentario' placeholder=''></textarea>";
                echo "</div>";
                echo "    <button type='submit' class='Producto__comentarios__formulario__boton lang btnVerdePrimario' id='newComment' data-lang='enviarComentario'></button>";
                echo "<input type='hidden' name='isbn13' id='isbn13' value=''>";
                echo "</form>";
            } else {
                echo '<a href="index.php?controller=LogIn&action=view" class="Producto__comentarios__formulario__boton lang" data-lang="registrate"></a>';
            }
            ?>
            <div class="Producto__comentarios__lista">
                <!-- Aquí se cargarán los comentarios -->
            </div>
        </article>

    </main>
    <?php
    require_once("view/components/footer.php");
    ?>

    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script type="module" src="./assets/js/comentarios.js"></script>
    <script type="module" src="./assets/js/cargarProducto.js"></script>
    <script type="module" src="./assets/js/lang.js"></script>
</body>

</html>