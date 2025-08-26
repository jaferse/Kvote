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

    <div class="containerMain">
        <main class="mainAdmin producto">
            <form method="post" name="formProducto" id="formProducto" enctype="multipart/form-data">
            </form>
            <form action="index.php?controller=Producto&action=create" method="post" name="formProductoNuevo" id="formProductoNuevo" enctype="multipart/form-data">
                <table class="tab">
                    <thead>
                        <tr>
                            <th scope="col" class="lang" data-lang="ISBN_13">ISBN_13</th>
                            <th scope="col" class="lang" data-lang="Portada" >Portada</th>
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
                        <tr>
                            <td>
                                <input aria-label='ISBN13 del producto' name="isbn_13" type="text" minlength="13" required class="isbn">
                            </td>
                            <td >
                                <input aria-label='Enlace para subir portada' type="file" name="portadaFile" class="portadaFile fileInput" id="fileInputInsert" accept="image/png, image/jpeg, image/webp, image/gif, image/bmp, image/svg+xml, image/x-icon">
                                <label for='fileInputInsert' class='fileInputLabel'>Subir</label>
                            </td>
                            <td><input aria-label='Nombre del producto' name="nombre" type="text" required class="nombre" minlength="1" maxlength="50"></td>
                            <td>
                                <select aria-label="Seleccione Artista" class="autor" name="autor" required>
                                    <option value="" disabled selected>Seleccione Artista</option>
                                    <?php
                                    foreach ($tablaAutor->artistas as $key => $value) {
                                        echo "<option value='" . $value->id . "'>" . $value->nombre . " " . $value->apellido1 . " " . $value->apellido2 . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select aria-label="Seleccione Trabajo del artista" class="trabajo" name="trabajo" required>
                                    <option class="lang" value="" disabled selected data-lang='seleccione'>Trabajo</option>
                                    <?php
                                    foreach ($tablaArtista_Producto->getEnum("trabajo") as $key => $value) {
                                        echo "<option class='lang' data-lang='" . $value . "' value='" . $value . "'>" . $value . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input aria-label='Colección a la que pertenece el producto' name="coleccion" type="text" required maxlength="45"></td>
                            <td><input aria-label='Número de la colección' name="numero" type="number" required max="99999"></td>
                            <td>
                                <select aria-label="Seleccione tipo de producto" class="tipo" name="tipo" required>
                                    <option class="lang" data-lang="seleccione" value="" disabled selected>Seleccione Tipo</option>
                                    <?php
                                    foreach ($tablaProducto->getEnum("tipo") as $key => $value) {
                                        echo "<option class='lang' data-lang='" . $value . "' value='" . $value . "'>" . $value . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select aria-label="Seleccione el formato del producto" class="formato" name="formato" required>
                                    <option class="lang" data-lang="seleccione" value="" disabled selected>Seleccione Formato</option>
                                    <?php
                                    foreach ($tablaProducto->getEnum("formato") as $key => $value) {
                                        echo "<option class='lang' data-lang='" . $value . "' value='" . $value . "'>" . $value . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input aria-label='Páginas del producto' name="paginas" type="number" required class="paginas" max="99999"></td>
                            <td>
                                <select aria-label="Seleccione el género del producto" class="subtipo" name="subtipo" required>
                                    <option class="lang" data-lang="seleccione" value='' disabled selected>Seleccione Género</option>
                                    <?php
                                    foreach ($tablaProducto->getEnum("subtipo") as $key => $valor) {
                                        echo "<option class='lang' data-lang='" . $valor . "' value='" . $valor . "'>" . $valor . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input aria-label='Editorial que lo publica' name="editorial" type="text" required maxlength="45"></td>
                            <td><input aria-label='Año de publicación' name="anio_publicacion" type="date" required></td>
                            <td>
                                <textarea aria-label='sinopsis del producto' name="sinopsis" required maxlength="16000"></textarea>
                            </td>
                            <td><input aria-label='Precio del producto' name="precio" type="number" step="0.01" required></td>
                            <td><input aria-label='stock del producto' class="stock" name="stock" type="number" required></td>
                            <td>
                                <input type="submit" value="Nuevo" class="btn btnPrimario lang" name="nuevoProducto" data-lang="nuevo">
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