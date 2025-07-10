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
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Pais</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Acción</th>
                </tr>


                <?php
                // Listar los artistas existentes en la base de datos

                foreach ($tablaListar as $key => $value) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<input name='" . "id_[" . $value->id . "]' type='text' value='" . $value->id . "' readonly>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input name='" . "nombre_[" . $value->id . "]' type='text' value='" . $value->nombre . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input name='" . "apellido1_[" . $value->id . "]' type='text' value='" . $value->apellido1 . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input name='" . "apellido2_[" . $value->id . "]' type='text' value='" . $value->apellido2 . "'>";
                    echo "</td>";
                    echo "<td>";
                    $paisSeleccionado = $tablaPais->obtener($value->pais);
                    echo "<select name='" . "pais_[" . $value->id . "]'>";
                    echo "<option value='' disabled>Seleccione País</option>";
                    foreach ($tablaPais->paiss as $key => $pais) {
                        echo "<option value='" . $pais->__get("codigo_iso") . "'" . (($value->pais == $pais->__get("codigo_iso")) ? "selected" : "") . ">" . $pais->__get("nombre") . "</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input name='" . "fecha_nacimiento_[" . $value->id . "]' type='date' value='" . $value->fecha_nacimiento . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='checkbox' name='check[" . $value->id . "]'>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>


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
                        <input type="submit" value="Nuevo" class="btnVerdePrimario" name="nuevoArtista">
                    </td>
                </tr>
            </table>
            <div>
                <input type="submit" value="Eliminar" class="btnRojo" name="eliminarArtista">
                <input type="submit" value="Actualizar" class="btnVerdePrimario" name="actualizarArtista">
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