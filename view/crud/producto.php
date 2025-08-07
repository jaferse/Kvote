<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once("model/artista/ArtistaPDO.php");
    require_once("model/artista_producto/Artista_productoPDO.php");
    require_once("view/components/meta.php");
    $productoController = new ProductoController();
    $tablaListar = $productoController->listar();
    $tablaAutor = new Daoartista("kvote_db");
    $tablaAutor->listar();
    ?>
    <title>Producto</title>
</head>

<body>
    <!-- Header -->
    <?php
    require_once("view/components/header.php");
    require_once("model/producto/ProductoPDO.php");

    $tablaProducto = new Daoproducto("kvote_db");
    $tablaArtista_Producto = new Daoartista_producto("kvote_db");

    $tablaProducto->listar();
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


    <main class="mainAdmin producto">
        <form action="" method="post" name="formProducto" id="formProducto" enctype="multipart/form-data">
        </form>
        <form action="index.php?controller=Producto&action=create" method="post" name="formProductoNuevo" id="formProductoNuevo" enctype="multipart/form-data">
            <table class="tab">
                <thead>
                    <tr>
                        <th scope="col" class="lang" data-lang="ISBN_13">ISBN_13</th>
                        <th scope="col" class="lang" data-lang="Portada" colspan="2">Portada</th>
                        <th scope="col" class="lang" data-lang="Nombre">Nombre</th>
                        <th scope="col" class="lang" data-lang="Autor">Autor</th>
                        <th scope="col" class="lang" data-lang="Trabajo">Trabajo</th>
                        <th scope="col" class="lang" data-lang="Coleccion">Coleccion</th>
                        <th scope="col" class="lang" data-lang="Numero">Numero</th>
                        <th scope="col" class="lang" data-lang="Tipo">Tipo</th>
                        <th scope="col" class="lang" data-lang="Formato">Formato</th>
                        <th scope="col" class="lang" data-lang="Páginas">Páginas</th>
                        <th scope="col" class="lang" data-lang="Género">Género</th>
                        <th scope="col" class="lang" data-lang="Editorial">Editorial</th>
                        <th scope="col" class="lang" data-lang="Año Publicación">Año Publicación</th>
                        <th scope="col" class="lang" data-lang="Sinopsis">Sinopsis</th>
                        <th scope="col" class="lang" data-lang="Precio">Precio</th>
                        <th scope="col" class="lang" data-lang="Stock">Stock</th>
                        <th scope="col" class="lang" data-lang="Acción">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Validar Formulario!!!!!!!!!!!!!!!!!!!!!!!! -->
                    <!-- Verifica tipo de dato de los imput -->
                    <td><input name="isbn_13" type="number" minlength="13" maxlength="13" required class="isbn"></td>
                    <td colspan="2">
                        <!-- <input name="portada" type="text"> -->
                        <input type="file" name="portadaFile" required class="portadaFile fileInput" id="fileInputInsert">
                        <label for='fileInputInsert' class='fileInputLabel'>Subir</label>

                    </td>
                    <td><input name="nombre" type="text" required class="nombre"></td>
                    <td>
                        <select class="autor" name="autor" id="" required class="autor">
                            <option value="" disabled selected>Seleccione Artista</option>
                            <?php
                            foreach ($tablaAutor->artistas as $key => $value) {
                                echo "<option value='" . $value->id . "'>" . $value->nombre . " " . $value->apellido1 . " " . $value->apellido2 . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="trabajo" name="trabajo" id="" required class="trabajo">
                            <option class="lang" value="" disabled selected class='lang' data-lang='seleccione'>Trabajo</option>
                            <?php
                            foreach ($tablaArtista_Producto->getEnum("trabajo") as $key => $value) {
                                echo "<option class='lang' data-lang='".$value."' value='" . $value . "'>" . $value . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input name="coleccion" type="text" required class="colleccion"></td>
                    <td><input name="numero" type="number" required class="numero"></td>
                    <td>
                        <select class="tipo" name="tipo" id="" required class="tipo">
                            <option class="lang" data-lang="seleccione" value="" disabled selected>Seleccione Tipo</option>
                            <?php
                            foreach ($tablaProducto->getEnum("tipo") as $key => $value) {
                                echo "<option class='lang' data-lang='".$value."' value='" . $value . "'>" . $value . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="formato" name="formato" id="" required class="formato">
                            <option class="lang" data-lang="seleccione" value="" disabled selected>Seleccione Formato</option>
                            <?php
                            foreach ($tablaProducto->getEnum("formato") as $key => $value) {
                                echo "<option class='lang' data-lang='".$value."' value='" . $value . "'>" . $value . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input name="paginas" type="number" required class="paginas"></td>
                    <td>
                        <select class="subtipo" name="subtipo" required class="subtipo">;
                            <option class="lang" data-lang="seleccione" value='' disabled selected>Seleccione Género</option>;
                            <?php
                            foreach ($tablaProducto->getEnum("subtipo") as $key => $valor) {
                                echo "<option class='lang' data-lang='".$valor."' value='" . $valor . "'"
                                    . ($valor == $value->subtipo ? 'selected' : '') .
                                    ">" . $valor . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input name="editorial" type="text" required class="editorial"></td>
                    <td><input name="anio_publicacion" type="date" required class="anio_publicacion"></td>
                    <td>
                        <textarea name="sinopsis" id="" required></textarea>
                    </td>
                    <td><input name="precio" type="number" step="0.01" required class="precio"></td>
                    <td><input class="stock" name="stock" type="number" required class="stock"></td>
                    </select></td>
                    <td>
                        <input type="submit" value="Nuevo" class="btn btnPrimario lang" name="nuevoProducto" data-lang="nuevo">
                    </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </main>

    <!-- Footer -->
    <?php
    require_once("view/components/footer.php");
    ?>

    <?php
    //Se da info sobre si se pudo insertar o no
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
    <script type="module" src="./assets/js/formularioProductoCRUD.js"></script>


</body>

</html>