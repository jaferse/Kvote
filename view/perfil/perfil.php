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
    if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] != true) {
        header("Location: index.php?controller=Index&action=view");
        header("Location: index.php?controller=LogIn&action=view");
    }
    ?>
    <div class="containerMain">
        <main class="perfilContainer">
            <div class="menuLateral">
                <!-- <ul> -->
                    <p class="top" data-lang="fotoPerfil">
                        <svg class='iconSvg' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M22 12C22 6.49 17.51 2 12 2C6.49 2 2 6.49 2 12C2 14.9 3.25 17.51 5.23 19.34C5.23 19.35 5.23 19.35 5.22 19.36C5.32 19.46 5.44 19.54 5.54 19.63C5.6 19.68 5.65 19.73 5.71 19.77C5.89 19.92 6.09 20.06 6.28 20.2C6.35 20.25 6.41 20.29 6.48 20.34C6.67 20.47 6.87 20.59 7.08 20.7C7.15 20.74 7.23 20.79 7.3 20.83C7.5 20.94 7.71 21.04 7.93 21.13C8.01 21.17 8.09 21.21 8.17 21.24C8.39 21.33 8.61 21.41 8.83 21.48C8.91 21.51 8.99 21.54 9.07 21.56C9.31 21.63 9.55 21.69 9.79 21.75C9.86 21.77 9.93 21.79 10.01 21.8C10.29 21.86 10.57 21.9 10.86 21.93C10.9 21.93 10.94 21.94 10.98 21.95C11.32 21.98 11.66 22 12 22C12.34 22 12.68 21.98 13.01 21.95C13.05 21.95 13.09 21.94 13.13 21.93C13.42 21.9 13.7 21.86 13.98 21.8C14.05 21.79 14.12 21.76 14.2 21.75C14.44 21.69 14.69 21.64 14.92 21.56C15 21.53 15.08 21.5 15.16 21.48C15.38 21.4 15.61 21.33 15.82 21.24C15.9 21.21 15.98 21.17 16.06 21.13C16.27 21.04 16.48 20.94 16.69 20.83C16.77 20.79 16.84 20.74 16.91 20.7C17.11 20.58 17.31 20.47 17.51 20.34C17.58 20.3 17.64 20.25 17.71 20.2C17.91 20.06 18.1 19.92 18.28 19.77C18.34 19.72 18.39 19.67 18.45 19.63C18.56 19.54 18.67 19.45 18.77 19.36C18.77 19.35 18.77 19.35 18.76 19.34C20.75 17.51 22 14.9 22 12ZM16.94 16.97C14.23 15.15 9.79 15.15 7.06 16.97C6.62 17.26 6.26 17.6 5.96 17.97C4.44 16.43 3.5 14.32 3.5 12C3.5 7.31 7.31 3.5 12 3.5C16.69 3.5 20.5 7.31 20.5 12C20.5 14.32 19.56 16.43 18.04 17.97C17.75 17.6 17.38 17.26 16.94 16.97Z' fill='#292D32' />
                            <path d='M12 6.92969C9.93 6.92969 8.25 8.60969 8.25 10.6797C8.25 12.7097 9.84 14.3597 11.95 14.4197C11.98 14.4197 12.02 14.4197 12.04 14.4197C12.06 14.4197 12.09 14.4197 12.11 14.4197C12.12 14.4197 12.13 14.4197 12.13 14.4197C14.15 14.3497 15.74 12.7097 15.75 10.6797C15.75 8.60969 14.07 6.92969 12 6.92969Z' fill='#292D32' />
                        </svg>
                        <span class="usuario"></span>
                    </p>
                    <button id="datosPersonales" class="lang buttonTransparent" data-lang="datosPersonales"></button>
                    <!-- <hr> -->
                    <button id="passWord" class="lang buttonTransparent" data-lang="passWord"></button>
                    <!-- <hr> -->
                    <button id="direcciones" class="lang buttonTransparent" data-lang="direcciones"></button>
                    <!-- <hr> -->
                    <button id="tarjetaCredito" class="lang buttonTransparent" data-lang="tarjetaCredito"></button>
                    <!-- <hr> -->
                    <button id="baja" class="lang buttonTransparent" data-lang="baja"></button>
                <!-- </ul> -->
            </div>
            <div class="containerContenido">
                <!-- CONTENEDOR BAJA -->
                <div class="container  containerBaja">
                    <h1 class="lang title" data-lang="title">Darse de baja</h1>
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
                    <div class="container__btn btn btnTerciario btnBaja enlaceBotonSmall">
                        <button class="lang buttonTransparent" data-lang="btnBaja"></button>
                    </div>
                </div>

                <!-- CONTENEDOR CONTRASEÑA -->
                <div class="container containerPassWord">
                    <h1 class="lang title" data-lang="title">Contraseña</h1>

                    <div class="formulario">
                        <form id="formularioPass" action="index.php?controller=Perfil&action=cambiarPassword" method="post">
                            <div class="formGroup">
                                <label for="passWordOld" class="lang" data-lang="passWordOld"></label>
                                <input type="password" id="passWordOld" name="passWordOld" required>
                            </div>

                            <div class="formGroup">
                                <label for="passWordNew" class="lang" data-lang="passWordNew"></label>
                                <input type="password" id="passWordNew" name="passWordNew" required>
                            </div>

                            <div class="formGroup">
                                <label for="passWordNew2" class="lang" data-lang="passWordNew2"></label>
                                <input type="password" id="passWordNew2" name="passWordNew2" required>
                            </div>

                            <input type="hidden" name="idUsuario" value=" <?php echo $_SESSION['usernameId']; ?>">

                            <div class="formGroup">
                                <input type="button" class="lang btn btnTerciario btnCambiarPass" data-lang="cambiarPass" value="Cambiar contraseña">
                            </div>

                        </form>
                    </div>
                </div>

                <!-- CONTENEDOR DATOS PERSONALES -->
                <div class="container containerDatosPersonales">
                    <h1 class="lang title" data-lang="title">Datos personales</h1>

                    <div class="formulario">
                        <form id="formularioDataUser" action="index.php?controller=Perfil&action=cambiarDatosUsuario" method="post">
                            <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['usernameId']; ?>">

                            <div class="formGroup">
                                <label for="nombre" class="lang" data-lang="Nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" value="" required maxlength="50">
                            </div>
                            <div class="formGroup">
                                <label for="Apellido1" class="lang" data-lang="Apellido1">Primer apellido:</label>
                                <input type="text" id="Apellido1" name="Apellido1" value="" required maxlength="45">
                            </div>
                            <div class="formGroup">
                                <label for="Apellido2" class="lang" data-lang="Apellido2">Segundo apellido:</label>
                                <input type="text" id="Apellido2" name="Apellido2" value="" required maxlength="45">
                            </div>
                            <div class="formGroup">
                                <input type="button" class="lang btn btnTerciario btnCambiarData" data-lang="cambiarData" value="Actualizar">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- CONTENEDOR DIRECCIONES -->
                <div class="container containerDirecciones">
                    <h1 class="lang title" data-lang="title">Direcciones</h1>
                    <div class="direcciones"></div>
                    <h1 class="lang newDireccion" data-lang="newDireccion">Nueva Dirección</h1>
                    <div class="formulario">
                        <form id="formularioDireccion" action="index.php?controller=Perfil&action=agregarDireccion" method="post">
                            <div class="formGroup">
                                <label for="pais" class="lang" data-lang="pais">País:</label>
                                <select name="pais" id="pais" required>
                                    <option class="lang" data-lang="Seleccione" value="">Seleccione un país</option>
                                    <option class="lang" data-lang="España" value="ES">España</option>
                                    <option class="lang" data-lang="Francia" value="FR">Francia</option>
                                    <option class="lang" data-lang="Portugal" value="PT">Portugal</option>
                                </select>
                            </div>
                            <div class="formGroup comunidad">
                            </div>
                            <div class="formGroup localidad">
                            </div>
                            <div class="formGroup">
                                <label for="codPostal" class="lang" data-lang="cPostal">Cod. Postal:</label>
                                <input type="text" id="codPostal" name="codPostal" required title="Debe ser un código postal de 7 dígitos" maxlength="7">
                            </div>
                            <div class="formGroup">
                                <label for="calle" class="lang" data-lang="Calle">Calle:</label>
                                <input type="text" id="calle" name="calle" required>
                            </div>
                            <div class="formGroup">
                                <label for="numero" class="lang" data-lang="Numero">Numero:</label>
                                <input type="number" id="numero" name="numero" required>
                            </div>
                            <div class="formGroup">
                                <label for="piso" class="lang" data-lang="Piso">Piso:</label>
                                <input type="text" id="piso" name="piso" required>
                            </div>
                            <div class="formGroup">
                                <label for="puerta" class="lang" data-lang="Puerta">Puerta:</label>
                                <input type="text" id="puerta" name="puerta" required>
                            </div>
                            <div>
                                <input type="submit" class="lang btn btnTerciario btnAddDireccion" data-lang="addDireccion" value="Añadir">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- CONTENEDOR TARJETA CREDITO -->
                <div class="container containerTarjetaCredito">
                    <h1 class="lang title" data-lang="title1">Tarjeta de crédito</h1>
                    <div class="tarjetasCredito"></div>
                    <h1 class="lang title" data-lang="title2">Nueva Tarjeta</h1>
                    <div class="formulario">
                        <form id="formularioTarjeta" action="index.php?controller=Perfil&action=addCreditCard" method="post">
                            <div class="formGroup">
                                <label class="labelNumeroTarjeta lang" for="numeroTarjeta" data-lang="tarjeta">Número de tarjeta</label>
                                <input type="text" id="numeroTarjeta" name="numeroTarjeta" required>
                            </div>
                            <div class="formGroup">
                                <label for="nombre_titular" class="lang" data-lang="nombreTitular">Nombre del titular</label>
                                <input type="text" id="nombre_titular" name="nombre_titular" required>
                            </div>
                            <div class="formGroup">
                                <label for="emisor_tarjeta" class="lang" data-lang="emisorTarjeta">Emisor de tarjeta</label>
                                <select name="emisor_tarjeta" id="emisor_tarjeta" required>
                                    <option class="lang" data-lang="SeleccioneEmisor" value="">Seleccione un emisor</option>
                                </select>
                            </div>
                            <div class="formGroup">
                                <label for="cvv_cvc" class="lang" data-lang="cvv">CVV</label>
                                <input type="number" id="cvv_cvc" name="cvv_cvc" required>
                            </div>
                            <div class="formGroup">
                                <label for="tipo_tarjeta" class="lang" data-lang="tipoTarjeta">Tipo de tarjeta</label>
                                <select name="tipo_tarjeta" id="tipo_tarjeta" required>
                                    <option class="lang" value="" data-lang="SeleccioneTipo">Seleccione un tipo de tarjeta</option>
                                </select>
                            </div>
                            <div class="formGroup">
                                <label for="fecha_caducidad" class="lang" data-lang="caducidad">Caducidad</label>
                                <input type="date" id="fecha_caducidad" name="fecha_caducidad" required>
                            </div>
                            <div>
                                <input type="submit" class="lang btn btnTerciario btnAddDireccion" data-lang="guardar" value="Añadir">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
        <div id="content" class="cardSkeleton" style="height: 70rem;">
            <div class="skeleton image" style="width: 100%; height: 100%;"></div>
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
    <script type="module" src="./assets/js/perfil.js"></script>

</body>

</html>