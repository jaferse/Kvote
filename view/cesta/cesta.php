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
    <div class="containerMain">
        <main class="containerCesta">
            <section class="containerSeccion">
                <h1 class="lang tituloCesta" data-lang="titulo">Carrito de Compras</h1>
                <div class="productos"></div>
                <div class="resumen">
                    <h2 class="titulo lang" data-lang="resCesta">Resumen cesta</h2>
                    <div class="resumen__total">
                        <p class="precioTotal"><span></span></p>
                        <div class="enlaceBotonSmall siguiente">
                            <button class="lang buttonTransparent" data-lang="siguiente"></button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="containerSeccion">
                <h1 class="lang titleDireccion" data-lang="title">Direcciones</h1>
                <div class="direcciones">
                    <div class="direcciones__contenedor"></div>
                    <div class="buttons">
                        <div class="enlaceBotonSmall anterior">
                            <button class="lang buttonTransparent" data-lang="anterior"></button>
                        </div>
                        <div class="enlaceBotonSmall siguiente">
                            <button class="lang buttonTransparent" data-lang="siguiente"></button>
                        </div>
                    </div>
                </div>
                <div class="enlaceBoton newDireccion">
                    <button class="buttonTransparent" data-lang="newDireccion">Añadir nuevas direcciones en el perfil</button>
                </div>
            </section>
            <section class="containerSeccion">
                <h1>Tarjetas</h1>
                <div class="tarjetas">
                    <div class="tarjetas__contenedor"></div>
                    <div class="buttons">
                        <div class="enlaceBotonSmall anterior">
                            <button class="lang buttonTransparent" data-lang="anterior"></button>
                        </div>
                        <div class="enlaceBotonSmall finalizarCompra">
                            <button class="lang buttonTransparent" data-lang="comprar"></button>
                        </div>
                    </div>
                </div>
                <div class="enlaceBoton newTarjeta">
                    <button class="buttonTransparent" data-lang="newTarjeta">Añadir nuevas tarjetas en el perfil</button>
                </div>
            </section>
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
    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script type="module" src="./assets/js/cesta.js"></script>
</body>
<script type="module" src="./assets/js/politicaPrivacidad.js"></script>

</html>