<!DOCTYPE html>
<html lang="es">

<head>
    <!-- 
        Me hubiese gustado implementar si hubiese tenido tiempo, el carrito de la compra,
        para poder mostrar el precio total de la compra, los productos y la cantidad
        Además también hubiese estado bien implementar el buscador para filtrar por titulo, autor, etc.
        Otra cosa interesante hubiese sido, una vez que te registraras, implementar el login, junto con 
        una sección de wishlist, pedidos realizados, etc
      -->
    <!-- Importamos links y metadatos -->
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
    <div class="containerMain">
        <main class="main" style="display: none;">
            <article class="main__sliderFrame">
                <ul>
                    <li>
                        <img src="./assets/img/carruselProvidence.jpg" alt="">
                    </li>
                    <li>
                        <img src="./assets/img/carruselTheWalkingDead.jpg" alt="">
                    </li>
                    <li>
                        <img src="./assets/img/carruselSpiderman.jpg" alt="">
                    </li>
                    <li>
                        <img src="./assets/img/carruselbatman.jpg" alt="">
                    </li>
                    <li>
                        <img src="./assets/img/carruselWonderWoman.jpg" alt="">
                    </li>
                    <li>
                        <img src="./assets/img/carrruselKilling.png" alt="">
                    </li>
                </ul>
            </article>

            <article class="main__bestSellers">
                <h2 class="main__bestSellers__title lang" data-lang="comicMonth">Comic de Febrero</h2>

                <section class="main__bestSellers__portadas">
                    <!-- Se renderiza los comic más vendidos -->
                </section>
            </article>
            <article class="main__bestSellers">
                <h2 class="main__bestSellers__title lang" data-lang="bookMonth">Libros de Febrero</h2>

                <section class="main__bestSellers__portadas">
                    <!-- Se renderiza los libros más vendidos -->
                </section>
            </article>
        </main>
        <div id="content" class="cardSkeleton" style="height: 50rem;">
            <div class="skeleton image" style="width: 100%; height: 60%;"></div>
            <div class="skeleton" style="flex: 1; height: 40%;"></div>
            <div class="skeleton" style="flex: 1; height: 40%;"></div>
        </div>
    </div>
    <?php
    require_once("view/components/footer.php");
    ?>

    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script src="./assets/js/carrusel.js"></script>
    <script type="module" src="./assets/js/masVendidos.js"></script>

</body>

</html>