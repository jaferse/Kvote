<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("view/components/meta.php");
    ?>
    <title>Registro</title>
</head>

<body>
    <div class="ContainerGlobal">

        <?php
        require_once("view/components/header.php");
        require_once("view/components/subMenu.php");
        require_once("model/tarjeta/TarjetaPDO.php");
        $tarjetaDao = new Daotarjeta(DDBB_NAME);
        ?>

        <main class="registro">
            <section class="registro__contenedor singIn">

                <h2 class="registro__title lang" data-lang="title">Bienvenido</h2>

                <form class="registro__formulario" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                    <div class="registro__formulario__group  lang" data-lang="nombreUsuario">
                        <label for="userName"></label> <input type="text" id="userName"
                            placeholder="Nombre Usuario" name="userName" required>
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="password1">
                        <label for="password"></label> <input type="password" id="password"
                            placeholder="Contraseña" name="password">
                    </div>
                    <?php
                    if (isset($_SESSION['logueado']) && $_SESSION['logueado'] == false) {
                        echo "<p class='error'>".$_SESSION['mensajeError']."</p>";
                        unset($_SESSION['logueado']);
                        unset($_SESSION['mensajeError']);
                    }
                    ?>
                    <a href="index.php?controller=SingIn&action=view" class="lang" data-lang="tieneCuenta?"></a>
                    <div class="registro__formulario__group  lang" data-lang="entrar">
                        <input type="submit" name="Entrar" value="Iniciar Sesión" id="botonRegistrar">
                    </div>

                </form>
            </section>
        </main>

        <?php
        require_once("view/components/footer.php");
        ?>

        <script src="./assets/js/lang.js"></script>
        <script src="./assets/js/darkMode.js"></script>
        <script src="./assets/js/animacionLogo.js"></script>
        <script src="./assets/js/search.js"></script>
        <script src="./assets/js/hamburguer.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/just-validate@latest/dist/just-validate.production.min.js"></script>
        <script src="./assets/js/singInFormulario.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.19/jquery.inputmask.min.js"></script>


</body>

</html>