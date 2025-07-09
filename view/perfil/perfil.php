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
                <li class="top" data-lang="fotoPerfil">
                    <img class="fotoPerfil" src="assets\img\batlogin1.png" alt="Foto de perfil">
                    <span class="usuario"></span>
                </li>
                <li id="datosPersonales" class="lang" data-lang="datosPersonales"></li>
                <hr>
                <li id="passWord" class="lang" data-lang="passWord"></li>
                <hr>
                <li id="direcciones" class="lang" data-lang="direcciones"></li>
                <hr>
                <li id="tarjetaCredito" class="lang" data-lang="tarjetaCredito"></li>
                <hr>
                <li id="baja" class="lang" data-lang="baja"></li>

            </ul>
        </div>
        <div class="containerContenido">
            <!-- CONTENEDOR BAJA -->
            <div class="container  containerBaja">
                <h2 class="lang title" data-lang="title"></h2>
                <div class="lang">
                    <p class="lang" data-lang="bajaTexto1">
                    </p>
                    <p class="lang" data-lang="bajaTexto2">
                    </p>
                    <ul>
                        <li class="lang" data-lang="bajaTexto3"></li>
                        <li class="lang" data-lang="bajaTexto4"></li>
                        <li class="lang" data-lang="bajaTexto5"></li>
                    </ul>
                    <p class="lang" data-lang="bajaTexto6">
                    </p>
                </div>
                <div class="container__btn btn btnRojo btnBaja">
                    <a class="lang" data-lang="btnBaja"></a>
                </div>
            </div>

            <!-- CONTENEDOR CONTRASEÑA -->
            <div class="container containerPassWord">
                <h2 class="lang title" data-lang="title">Contraseña</h2>

                <div class="formulario">
                    <form id="formularioPass" action="index.php?controller=Perfil&action=cambiarPassword" method="post">
                        <div class="formGroup">
                            <label for="passWordOld" class="lang" data-lang="passWordOld"></label> <input type="password" id="passWordOld" name="passWordOld" required>
                        </div>

                        <div class="formGroup">
                            <label for="passWordNew" class="lang" data-lang="passWordNew"></label> <input type="password" id="passWordNew" name="passWordNew" required>
                        </div>

                        <div class="formGroup">
                            <label for="passWordNew2" class="lang" data-lang="passWordNew2"></label> <input type="password" id="passWordNew2" name="passWordNew2" required>
                        </div>

                        <div class="formGroup">
                            <input type="button" class="lang btn btnRojo btnCambiarPass" data-lang="cambiarPass" value="">
                        </div>

                    </form>
                </div>
            </div>

            <!-- CONTENEDOR DATOS PERSONALES -->
            <div class="container containerDatosPersonales">
                <h2
                    class="lang title" data-lang="title">Datos personales</h2>
            </div>
            <!-- CONTENEDOR DIRECCIONES -->
            <div class="container containerDirecciones">
                <h2 class="lang title" data-lang="title">Direcciones</h2>

            </div>

            <!-- CONTENEDOR TARJETA CREDITO -->
            <div class="container containerTarjetaCredito">
                <h2 class="lang title" data-lang="title">Tarjeta credito</h2>

            </div>
        </div>

    </main>
    <?php
    require_once("view/components/footer.php");
    ?>
    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script type="module" src="./assets/js/perfil.js"></script>



</body>

</html>