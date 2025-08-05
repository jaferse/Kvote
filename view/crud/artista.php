<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once("view/components/meta.php");
    $artistaController = new ArtistaController();
    $tablaListar = $artistaController->listar();
    ?>
    <title>Artista</title>
</head>

<body>
    <!-- Header -->
    <?php
    require_once("view/components/header.php");
    require_once("model/artista/ArtistaPDO.php");
    require_once("model/pais/PaisPDO.php");
    $tablaArtistas = new Daoartista("kvote_db");
    $tablaPais = new Daopais("kvote_db");

    $tablaPais->listar();
    ?>

    <nav class="subMenuContainer">
        <div class="submenu">
            <?php
            require_once("view/components/subMenu.php");
            ?>
        </div>
        <div class="subMenuCrud">
            <?php
            require_once("view/components/navegadorCrud.php");
            ?>
        </div>
    </nav>
    <main class="mainAdmin">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="formArtista" id="formArtista">
            <h1 class="titulo">Artista</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Pais</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody class="artistaCrud">

                </tbody>
                <tbody class="artistaInsert">

                    <!-- Insertar nuevo artista -->
                    <tr>
                        <!-- Validar Formulario!!!!!!!!!!!!!!!!!!!!!!!! -->

                        <td>
                            <?php
                            echo  "<input name='id' type='text' readonly value='";


                            $tablaArtistas->obtenerId();
                            echo $tablaArtistas->obtenerId();
                            echo "'>";
                            ?>
                        </td>
                        <td><input name="nombre" type="text"></td>
                        <td><input name="apellido1" type="text"></td>
                        <td><input name="apellido2" type="text"></td>
                        <td><select name="pais" id="">
                                <option value="" disabled selected>Seleccione País</option>
                                <?php
                                foreach ($tablaPais->paiss as $key => $value) {
                                    echo "<option value='" . $value->__get("codigo_iso") . "'>" . $value->__get("nombre") . "</option>";
                                }
                                ?>
                            </select></td>
                        <td><input name="fecha_nacimiento" type="date"></td>
                        <td>
                            <input type="submit" value="Nuevo" class="btn btnPrimario" name="nuevoArtista">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <input type="submit" value="Eliminar" class="btn btnTerciario" name="eliminarArtista">
                <input type="submit" value="Actualizar" class="btn btnPrimario" name="actualizarArtista">
            </div>
        </form>
    </main>
    <!-- Footer -->
    <?php
    require_once("view/components/footer.php");
    ?>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->

    <!-- Se da info sobre si se pudo insertar o no  -->
    <?php

    if (isset($_GET["estado"])) {
        if ($_GET["estado"] == 1) {
            echo "<script>alert('Acción realizada correctamente');</script>";
        } else {
            echo "<script>alert('Error al realizar la acción');</script>";
        }
    }
    ?>

    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script src="./assets/js/cambioActionArtista.js"></script>

</body>

</html>