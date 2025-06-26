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
            <section class="registro__contenedor SingIn">

                <h2 class="registro__title lang" data-lang="title">Rellene el formulario</h2>

                <form class="registro__formulario" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                    <div class="registro__formulario__group  lang" data-lang="nombreUsuario">
                        <label for="userName">Nombre Usuario </label> <input type="text" id="userName"
                            placeholder="Nombre Usuario" name="userName" required>
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="Nombre">
                        <label for="nombre">Nombre </label> <input type="text" id="nombre" placeholder="Nombre"
                            name="nombre" required>
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="Apellido1">
                        <label for="apellido1">Primer Apellido </label> <input type="text" id="apellido1"
                            placeholder="Primer Apellido" name="apellido1" required>
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="Apellido2">
                        <label for="apellido2">Segundo Apellido </label> <input type="text" id="apellido2"
                            placeholder="Segundo Apellido" name="apellido2">
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="email">
                        <label for="email">Correo Electrónico </label> <input type="email" id="email"
                            placeholder="Correo Electrónico" name="email">
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="password1">
                        <label for="password">Contraseña </label> <input type="password" id="password"
                            placeholder="Contraseña" name="password">
                        <span class="toggle-password" id="togglePassword">
                            <img class="eye" src="./assets/img/eye.png" alt="toggle-password">
                        </span>
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="password2">
                        <label for="password2">Confirme Contraseña </label> <input type="password" id="password2"
                            placeholder="Confirme Contraseña" name="password2">
                        <span class="toggle-password" id="togglePassword">
                            <img class="eye" src="./assets/img/eye.png" alt="toggle-password">
                        </span>
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="fecha">
                        <label for="birth">Fecha nacimiento</label><input type="date" id="birth"
                            placeholder="Fecha Nacimiento" name="birth">
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="tarjeta">
                        <label for="tarjeta">Nº Tarjeta de Credito</label>
                        <input type="text" id="tarjeta" placeholder="xxxx-xxxx-xxxx-xxxx"
                            name="tarjeta">
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="caducidad">
                        <label for="caducidad">Caducidad</label>
                        <input type="text" id="caducidad" placeholder="MM/AA" name="caducidad">
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="cvv">
                        <label for="CVV">CVV</label>
                        <input type="text" id="CVV" maxlength="3" placeholder="xxx" name="CVV">
                    </div>
                    <div class="registro__formulario__group lang" data-lang="genero">
                        <label for="generoFavorito">Género Favorito: </label>
                        <select name="generoFavorito" id="generoFavorito">
                            <option value="" data-lang="opcion1">Seleccione un género</option>
                            <option value="Americano" data-lang="opcion2">Americano</option>
                            <option value="Europeo" data-lang="opcion3">Europeo</option>
                            <option value="Manga" data-lang="opcion4">Manga</option>
                            <option value="Indie" data-lang="opcion5">Indie</option>
                            <option value="Novela" data-lang="opcion6">Novela</option>
                            <option value="Otro" data-lang="opcion7">Otros</option>
                        </select>
                    </div>
                    <div class="registro__formulario__group lang" data-lang="tipo_tarjeta">
                        <label for="tipo_tarjeta">Tipo de Tarjeta</label>
                        <select name="tipo_tarjeta" id="tipo_tarjeta">
                            <option value="" data-lang="tipoTarjeta0">Selecionar tipo de tarjeta</option>
                            <?php
                            // var_dump($tarjetaDao->getEnum("tipo_tarjeta"));
                            foreach ($tarjetaDao->getEnum("tipo_tarjeta") as $key => $tipoTarjeta) {
                                echo "<option value='$tipoTarjeta' data-lang='tipoTarjeta" . ($key + 1) . "'>$tipoTarjeta</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="registro__formulario__group lang" data-lang="emisor_tarjeta">
                        <label for="emisor_tarjeta">Emisor de Tarjeta</label>
                        <select name="emisor_tarjeta" id="emisor_tarjeta">
                            <option value="" data-lang="emisor0">Selecionar emisor de tarjeta</option>
                            <?php
                            // var_dump($tarjetaDao->getEnum("tipo_tarjeta"));
                            foreach ($tarjetaDao->getEnum("emisor_tarjeta") as $key => $emisorTarjeta) {
                                echo "<option value='$emisorTarjeta' data-lang='emisor" . ($key + 1) . "'>$emisorTarjeta</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="enlaceBoton">
                        <a href="index.php?controller=LogIn&action=view" class="lang " data-lang="yaTienesCuenta"></a>
                    </div>
                    <div class="registro__formulario__group  lang" data-lang="registrar">
                        <input type="submit" name="enviar" value="Registrarse" id="botonRegistrar" class="btnVerdePrimario">
                    </div>
                </form>
                <div class="progress-container">
                    <svg class="progress-circle" width="120" height="120" viewBox="0 0 120 120">
                        <circle class="circle-background" cx="60" cy="60" r="54" stroke="#e6e6e6" stroke-width="12"
                            fill="none" />
                        <circle class="circle-progress" cx="60" cy="60" r="54" stroke="#B8001F" stroke-width="12"
                            fill="none" stroke-dasharray="339.292" stroke-dashoffset="339.292" />
                    </svg>
                    <div class="progress-text"></div>
                </div>
            </section>
        </main>

        <?php
        require_once("view/components/footer.php");
        ?>

        <script type="module" src="./assets/js/lang.js"></script>
        <script src="./assets/js/darkMode.js"></script>
        <!-- <script src="./assets/js/animacionLogo.js"></script> -->
        <script src="./assets/js/search.js"></script>
        <script src="./assets/js/hamburguer.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/just-validate@latest/dist/just-validate.production.min.js"></script>
        <script type="module" src="./assets/js/validacionFormulario.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.19/jquery.inputmask.min.js"></script>


</body>

</html>