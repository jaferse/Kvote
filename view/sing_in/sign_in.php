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
        <div class="containerMain">
            <main class="registro">
                <section class="registro__contenedor SingIn">

                    <h1 class="registro__title lang" data-lang="title">Rellene el formulario</h1>

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
                                <svg class="iconSvg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24.151 22.393c2.386-2.207 3.88-5.364 3.88-8.87 0-6.672-5.409-12.081-12.081-12.081s-12.081 5.409-12.081 12.081c0 3.507 1.495 6.664 3.881 8.871l-0.212 0.014c-1.64 2.829-0.321 5.096 1.55 7.268-0.445-1.827-0.737-3.695 0.445-5.916 0.231 0.145 0.466 0.282 0.707 0.412-0.715 2.631 0.1 4.823 1.695 6.683-0.256-1.69-0.329-3.572 0.501-5.77 0.206 0.063 0.414 0.119 0.624 0.171 0.111 2.251 0.821 4.35 1.753 6.391-0.083-1.985 0.059-3.998 0.569-6.056 0.188 0.009 0.377 0.014 0.567 0.014 0.192 0 0.384-0.005 0.574-0.014 0.511 2.058 0.653 4.071 0.569 6.056 0.932-2.042 1.643-4.141 1.753-6.393 0.21-0.052 0.418-0.109 0.623-0.171 0.831 2.198 0.758 4.081 0.502 5.772 1.596-1.86 2.411-4.053 1.694-6.686 0.24-0.129 0.476-0.267 0.706-0.412 1.185 2.223 0.892 4.091 0.447 5.919 1.871-2.172 3.189-4.439 1.55-7.268l-0.219-0.014zM8.422 15.574c0-4.159 3.371-7.53 7.53-7.53s7.53 3.371 7.53 7.53-3.372 7.53-7.53 7.53-7.53-3.371-7.53-7.53z"></path>
                                    <!-- Ojo cerrado (línea curva en lugar de pupila) -->
                                    <path class="eye-closed contorno--stroke" d="M12 15.5 Q16 17 20 15.5" stroke="#000" stroke-width="1.5" fill="none" stroke-linecap="round" />

                                    <!-- Ojo abierto (línea curva en lugar de pupila) -->
                                    <path style="display: none;" class="eye-open" d="M17.509 13.796c-1.258 0-2.278-1.020-2.278-2.278 0-0.353 0.081-0.688 0.224-0.986-2.116 0.394-3.717 2.249-3.717 4.479 0 2.517 2.040 4.557 4.557 4.557s4.557-2.040 4.557-4.557c-0-1.145-0.422-2.191-1.12-2.991-0.229 1.017-1.136 1.777-2.222 1.777zM16.065 17.749c-0.818 0-1.481-0.663-1.481-1.481s0.663-1.481 1.481-1.481c0.818 0 1.481 0.663 1.481 1.481s-0.663 1.481-1.481 1.481z"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="registro__formulario__group  lang" data-lang="password2">
                            <label for="password2">Confirme Contraseña </label> <input type="password" id="password2"
                                placeholder="Confirme Contraseña" name="password2">
                            <span class="toggle-password" id="togglePassword">
                                <svg class="iconSvg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24.151 22.393c2.386-2.207 3.88-5.364 3.88-8.87 0-6.672-5.409-12.081-12.081-12.081s-12.081 5.409-12.081 12.081c0 3.507 1.495 6.664 3.881 8.871l-0.212 0.014c-1.64 2.829-0.321 5.096 1.55 7.268-0.445-1.827-0.737-3.695 0.445-5.916 0.231 0.145 0.466 0.282 0.707 0.412-0.715 2.631 0.1 4.823 1.695 6.683-0.256-1.69-0.329-3.572 0.501-5.77 0.206 0.063 0.414 0.119 0.624 0.171 0.111 2.251 0.821 4.35 1.753 6.391-0.083-1.985 0.059-3.998 0.569-6.056 0.188 0.009 0.377 0.014 0.567 0.014 0.192 0 0.384-0.005 0.574-0.014 0.511 2.058 0.653 4.071 0.569 6.056 0.932-2.042 1.643-4.141 1.753-6.393 0.21-0.052 0.418-0.109 0.623-0.171 0.831 2.198 0.758 4.081 0.502 5.772 1.596-1.86 2.411-4.053 1.694-6.686 0.24-0.129 0.476-0.267 0.706-0.412 1.185 2.223 0.892 4.091 0.447 5.919 1.871-2.172 3.189-4.439 1.55-7.268l-0.219-0.014zM8.422 15.574c0-4.159 3.371-7.53 7.53-7.53s7.53 3.371 7.53 7.53-3.372 7.53-7.53 7.53-7.53-3.371-7.53-7.53z"></path>
                                    <!-- Ojo cerrado (línea curva en lugar de pupila) -->
                                    <path class="eye-closed contorno--stroke" d="M12 15.5 Q16 17 20 15.5" stroke="#000" stroke-width="1.5" fill="none" stroke-linecap="round" />

                                    <!-- Ojo abierto (línea curva en lugar de pupila) -->
                                    <path style="display: none;" class="eye-open" d="M17.509 13.796c-1.258 0-2.278-1.020-2.278-2.278 0-0.353 0.081-0.688 0.224-0.986-2.116 0.394-3.717 2.249-3.717 4.479 0 2.517 2.040 4.557 4.557 4.557s4.557-2.040 4.557-4.557c-0-1.145-0.422-2.191-1.12-2.991-0.229 1.017-1.136 1.777-2.222 1.777zM16.065 17.749c-0.818 0-1.481-0.663-1.481-1.481s0.663-1.481 1.481-1.481c0.818 0 1.481 0.663 1.481 1.481s-0.663 1.481-1.481 1.481z"></path>
                                </svg>
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

                        <div class="enlaceBoton">
                            <a href="index.php?controller=LogIn&action=view" class="lang " data-lang="yaTienesCuenta"></a>
                        </div>
                        <div class="registro__formulario__group  lang" data-lang="registrar">
                            <input type="submit" name="enviar" value="Registrarse" id="botonRegistrar" class="btn btnPrimario">
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
            <div id="content" class="cardSkeleton" style="height: 70rem;">
                <div class="skeleton image" style="width: 50%; height: 100%; margin: 0 auto; border-radius: 18px;"></div>
            </div>
        </div>
        <?php
        require_once("view/components/footer.php");
        ?>

        <script type="module" src="./assets/js/lang.js"></script>
        <script src="./assets/js/darkMode.js"></script>
        <script src="./assets/js/search.js"></script>
        <script src="./assets/js/hamburguer.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/just-validate@latest/dist/just-validate.production.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.19/jquery.inputmask.min.js"></script>
        <script type="module" src="./assets/js/validacionFormulario.js"></script>
<script type="module" src="./assets/js/politicaPrivacidad.js"></script>

</body>

</html>