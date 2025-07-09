<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("view/components/meta.php");
    ?>
    <title>Registro</title>
</head>

<body>
    <?php
    require_once("view/components/header.php");
    require_once("view/components/subMenu.php");
    require_once("model/tarjeta/TarjetaPDO.php");
    $tarjetaDao = new Daotarjeta(DDBB_NAME);
    ?>
    <main class="perfilContainer">
        <div class="menuLateral">
            <ul>
                <li class="lang top" data-lang="fotoPerfil"><img class="fotoPerfil" src="assets\img\batlogin1.png" alt="Foto de perfil"><span class="usuario">Nombre del usuario</span></li>
                <li class="lang" data-lang="datosPersonales">Datos personales</li>
                <li class="lang" data-lang="passWord">Contraseña</li>
                <li class="lang" data-lang="direcciones">Direcciones</li>
                <li class="lang" data-lang="tarjetaCredito">Metodos de pago</li>
                <li class="lang" data-lang="baja">Darse de baja</li>
            </ul>
        </div>
        <div class="containerContenido"></div>



    </main>
    <?php
    require_once("view/components/footer.php");
    ?>
    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script src="./assets/js/perfil.js"></script>



</body>

</html>