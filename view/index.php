<!DOCTYPE html>
<html lang="es">

<head>
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
            <div class="main__sliderFrame">
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
            </div>

            <article class="main__bestSellers">
                <h1 class="main__bestSellers__title lang" data-lang="comicMonth">Comic de Febrero</h1>
                <div class="main__bestSellers__portadas">
                    <!-- Se renderiza los comic más vendidos -->
                </div>
            </article>
            <article class="main__bestSellers">
                <h1 class="main__bestSellers__title lang" data-lang="bookMonth">Libros de Febrero</h1>
                <div class="main__bestSellers__portadas">
                    <!-- Se renderiza los libros más vendidos -->
                </div>
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