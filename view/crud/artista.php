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
            $hoy = date("Y-m-d");
            ?>
        </div>
    </nav>
    <div class="containerMain">
        <main class="mainAdmin artista">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="formArtista" id="formArtista">
                <h1 class="titulo lang" data-lang="title">Artista</h1>
                <table>
                    <thead>
                        <tr>
                            <th class="lang" data-lang="id">ID</th>
                            <th class="lang" data-lang="nombre">Nombre</th>
                            <th class="lang" data-lang="apellido1">Primer Apellido</th>
                            <th class="lang" data-lang="apellido2">Segundo Apellido</th>
                            <th class="lang" data-lang="pais">Pais</th>
                            <th class="lang" data-lang="nacimientoFecha">Fecha de Nacimiento</th>
                            <th class="lang" data-lang="accion">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="artistaCrud">

                    </tbody>
                </table>
                <div>
                    <input type="submit" value="Eliminar" class="btn btnTerciario lang" name="eliminarArtista" data-lang="eliminar">
                    <input type="submit" value="Actualizar" class="btn btnPrimario lang" name="actualizarArtista" data-lang="actualizar">
                </div>
            </form>
            <form action="index.php?controller=Artista&action=create" method="post" name="formArtista" id="formArtistaCreate">
                <h1 class="titulo lang" data-lang="title">Añadir Artista</h1>
                <table>
                    <thead>
                        <tr>
                            <th class="lang" data-lang="id">ID</th>
                            <th class="lang" data-lang="nombre">Nombre</th>
                            <th class="lang" data-lang="apellido1">Primer Apellido</th>
                            <th class="lang" data-lang="apellido2">Segundo Apellido</th>
                            <th class="lang" data-lang="pais">Pais</th>
                            <th class="lang" data-lang="nacimientoFecha">Fecha de Nacimiento</th>
                            <th class="lang" data-lang="accion">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="artistaInsert">

                        <!-- Insertar nuevo artista -->
                        <tr>
                            <td>
                                <?php
                                echo  "<input name='id' type='text' readonly value='";
                                $tablaArtistas->obtenerId();
                                echo $tablaArtistas->obtenerId();
                                echo "'>";
                                ?>
                            </td>
                            <td><input name="nombre" type="text" required minlength="2" maxlength="50"></td>
                            <td><input name="apellido1" type="text" required minlength="2" maxlength="45"></td>
                            <td><input name="apellido2" type="text" minlength="2" maxlength="45"></td>
                            <td><select name="pais" required>
                                    <option class="lang" data-lang="Seleccione" value="" disabled selected>Seleccione País</option>
                                    <?php
                                    foreach ($tablaPais->paiss as $key => $value) {
                                        echo "<option value='" . $value->__get("codigo_iso") . "'>" . $value->__get("nombre") . "</option>";
                                    }
                                    ?>
                                </select></td>
                            <td><input name="fecha_nacimiento" type="date" max='<?php echo $hoy; ?>' required></td>
                            <td>
                                <input type="submit" value="Nuevo" class="btn btnPrimario lang" name="nuevoArtista" data-lang="nuevo">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </main>
        <div id="content" class="cardSkeleton" style="height: 70rem;">
            <div class="skeleton image" style="width: 100%; height: 100%; margin: 0 auto; border-radius: 18px;"></div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    require_once("view/components/footer.php");
    ?>

    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script type="module" src="./assets/js/cambioActionArtista.js"></script>

</body>

</html>