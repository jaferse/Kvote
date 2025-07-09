<!-- <div class="Container">
    <div class="Container__spinner">
        <div class="Container__spinner__img"></div>
    </div>
</div> -->
<?php
// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<header class="header">
    <a class="header__logo" href="/">
    </a>
    <div class="menuHamburguesa">
        <img src="./assets/img/hamburgerIcon.svg" alt="Icono de hamburguesa">
    </div>
    <nav class="nav">
        <div class="nav__menu">

            <a href="index.php?controller=Catalogo&action=novedades" class="nav__menu__button">
                <i class="lang" data-lang="primero"></i>
            </a>
            <hr>
            <a href="index.php?controller=Catalogo&action=comic" class="nav__menu__button">
                <i class="lang" data-lang="segundo"></i>
            </a>
            <hr>
            <a href="index.php?controller=Catalogo&action=libros" class="nav__menu__button">
                <i class="lang" data-lang="tercero"></i>
            </a>
            <hr>

            <a href="index.php?controller=Nosotros&action=view" class="nav__menu__button">
                <i class="lang" data-lang="quinto"></i>
            </a>
            <hr>
        </div>
        <div class="nav__login">
            <div class="login">
                <?php
                if (
                    isset($_SESSION['logueado'])
                    && $_SESSION['logueado'] == true
                ) {
                    echo " <a class='logeado'></a>";
                    echo " <a class='carro' href='index.php?controller=Cesta&action=view'></a>";
                } else {
                    echo " <a href='index.php?controller=LogIn&action=view' class='login'></a>";
                    echo " <a class='carro' href='index.php?controller=LogIn&action=view'></a>";
                }
                ?>
                <div class="menuLogin menu none">
                    <div class="menu__button">
                        <a class="lang" data-lang="pedidos" href="index.php?controller=HistorialPedidos&action=view">Pedidos</a>
                    </div>
                    <hr>
                    <div class="menu__button">

                    <a class="lang" data-lang="perfil" href="index.php?controller=Perfil&action=view">Perfil</a>
                    </div>
                    <hr>
                    <div class="menu__button">

                    <a class="lang" data-lang="wishList" href="index.php?controller=WishList&action=view">Wishlist</a>
                    </div>
                    <hr>
                    <?php
                    if (
                        isset($_SESSION['logueado'])
                        && $_SESSION['logueado'] == true
                        &&  isset($_SESSION['admin'])
                        && $_SESSION['admin'] == true
                    ) {
                    
                        echo "<div class='menu__button'>";
                        echo "    <a href='index.php?controller=Artista&action=view' class='lang' data-lang='admin'>";
                        echo "  </a>";
                        echo "</div>";
                        echo "<hr>";
                    }

                    ?>
                    <div class="menu__button">
                    <a class="lang" data-lang="cerrarSession" href="index.php?controller=LogIn&action=logOut">Cerrar Sesión</a>
                    </div>
                </div>

            </div>
            <div class="search">
                <label for="buscar"></label><input type="text" id="buscar">
            </div>
        </div>
    </nav>

</header>
<script src="/assets/js/menuLogin.js"></script>