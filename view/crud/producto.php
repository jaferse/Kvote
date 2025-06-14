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
    // require_once("model/pais/PaisPDO.php");

    $tablaProducto = new Daoproducto("kvote_db");
    $tablaArtista_Producto = new Daoartista_producto("kvote_db");

    $tablaProducto->listar();
    ?>
    <nav class="subnavegador">
        <?php
        require_once("view/components/navegadorCrud.php");
        ?>
    </nav>


    <main class="mainAdmin">
        <form action="" method="post" name="formProducto" id="formProducto" enctype="multipart/form-data">
            <h1 class="titulo">Producto</h1>
            <table class="tab">
                <tr>
                    <th scope="col">ISBN_13</th>
                    <th scope="col">Portada </th>
                    <th scope="col">Nueva Portada</th>
                    <th scope="col">Nombre </th>
                    <th scope="col">Autor </th>
                    <th scope="col">Trabajo</th>
                    <th scope="col">Coleccion </th>
                    <th scope="col">Numero</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Formato</th>
                    <th scope="col">Páginas</th>
                    <th scope="col">Género</th>
                    <th scope="col">Editorial</th>
                    <th scope="col">Año Publicación</th>
                    <th scope="col">Sinopsis</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Acción</th>
                </tr>


                <?php
                // Listar los Producto existentes en la base de datos

                foreach ($tablaListar as $key => $value) {
                    //Sacamos el artista del producto
                    $artista = ($tablaArtista_Producto->obtenerArtista_Producto($value->isbn_13));
                    // echo $artista->id;
                    echo "<tr>";
                    echo "<td>";
                    echo "<input class='isbn' name='" . "isbn_13_[" . $value->isbn_13 . "]' type='text' value='" . $value->isbn_13 . "' readonly >";
                    echo "</td>";
                    echo "<td>";
                    //Modificar para que se pueda cambiar la portada
                    echo "<img src='data:image/jpg;base64," . $value->portada . "' width='120px'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='file' name='portadaFile_[" . $value->isbn_13 . "]' class='fileInput' id='fileInput'>";
                    echo "<label for='fileInput' class='fileInputLabel'>Subir</label>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='nombre' name='" . "nombre_[" . $value->isbn_13 . "]' type='text' value='" . $value->nombre . "'>";
                    echo "</td>";
                    echo "<td>";
                    $nombreArtista = $tablaAutor->obtener($artista->artista_id)->nombre . " " . $tablaAutor->obtener($artista->artista_id)->apellido1 . " " . $tablaAutor->obtener($artista->artista_id)->apellido2;
                    // echo "<input name='" . "autor_[" . $value->isbn_13 . "]' type='text' value='" . $nombreArtista . "' id='" . $artista->artista_id . " 'readonly>";
                    echo "<select class='autor' name='" . "autor_[" . $value->isbn_13 . "]' id=''>";
                    echo "<option value='' disabled selected>Seleccione Autor</option>";

                    foreach ($tablaAutor->artistas as $key => $valor) {

                        echo "<option value='" . $valor->id . "'"
                            . ($valor->id == $artista->artista_id ? 'selected' : '') .
                            ">" . $valor->nombre . " " . $valor->apellido1 . " " . $valor->apellido2 . "</option>";
                    }

                    echo "  </select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<select class='trabajo' name='" . "trabajo_[" . $value->isbn_13 . "]' id=''>";
                    echo "<option value='' disabled selected>Seleccione Trabajo</option>";


                    foreach ($tablaArtista_Producto->getEnum("trabajo") as $key => $valor) {
                        //Sacamos el trabajo del artista del producto
                        $trabajo = $tablaArtista_Producto->obtener($artista->artista_id, $value->isbn_13)->trabajo;
                        echo "<option value='" . $valor . "'"
                            . (($valor == $trabajo) ? 'selected' : '') .
                            ">" . $valor . "</option>";
                    }

                    echo "  </select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='colleccion' name='" . "coleccion_[" . $value->isbn_13 . "]' type='text' value='" . $value->coleccion . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='numero' name='" . "numero_[" . $value->isbn_13 . "]' type='number' value='" . $value->numero  . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<select class='tipo' name='" . "tipo_[" . $value->isbn_13 . "]' id=''>";
                    echo "<option value='' disabled selected>Seleccione Formato</option>";

                    foreach ($tablaProducto->getEnum("tipo") as $key => $valor) {
                        echo "<option value='" . $valor . "'"
                            . ($valor == $value->tipo ? 'selected' : '') .
                            ">" . $valor . "</option>";
                    }

                    echo "  </select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<select class='formato' name='" . "formato_[" . $value->isbn_13 . "]' id=''>";
                    echo "<option value='' disabled selected>Seleccione Formato</option>";

                    foreach ($tablaProducto->getEnum("formato") as $key => $valor) {
                        echo "<option value='" . $valor . "'"
                            . ($valor == $value->formato ? 'selected' : '') .
                            ">" . $valor . "</option>";
                    }

                    echo "  </select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='paginas' name='" . "paginas_[" . $value->isbn_13 . "]' type='number' value='" . $value->paginas  . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<select class='subtipo' name='" . "subtipo_[" . $value->isbn_13 . "]' id=''>";
                    echo "<option value='' disabled selected>Seleccione Género</option>";

                    foreach ($tablaProducto->getEnum("subtipo") as $key => $valor) {
                        echo "<option value='" . $valor . "'"
                            . ($valor == $value->subtipo ? 'selected' : '') .
                            ">" . $valor . "</option>";
                    }

                    echo "  </select>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='editorial' name='" . "editorial_[" . $value->isbn_13 . "]' type='text' value='" . $value->editorial . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='anio_publicacion' name='" . "anio_publicacion_[" . $value->isbn_13 . "]' type='date' value='" . $value->anio_publicacion . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<textarea class='sinopsis' name='" . "sinopsis_[" . $value->isbn_13 . "]' type='text'>$value->sinopsis</textarea>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='precio' name='" . "precio_[" . $value->isbn_13 . "]' type='number' value='" . $value->precio . "' step='0.01'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='stock' name='" . "stock_[" . $value->isbn_13 . "]' type='number' value='" . $value->stock . "'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='check' type='checkbox' name='check[" . $value->isbn_13 . "]'>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>

                <!-- Validar Formulario!!!!!!!!!!!!!!!!!!!!!!!! -->
                <!-- Verifica tipo de dato de los imput -->
                <td><input name="isbn_13" type="text"></td>
                <td colspan="2">
                    <!-- <input name="portada" type="text"> -->
                    <input type="file" name="portadaFile">
                </td>
                <td><input name="nombre" type="text"></td>
                <td>
                    <select class="autor" name="autor" id="">
                        <option value="" disabled selected>Seleccione Artista</option>
                        <?php
                        foreach ($tablaAutor->artistas as $key => $value) {
                            echo "<option value='" . $value->id . "'>" . $value->nombre . " " . $value->apellido1 . " " . $value->apellido2 . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select class="trabajo" name="trabajo" id="">
                        <option value="" disabled selected>Trabajo</option>
                        <?php
                        foreach ($tablaArtista_Producto->getEnum("trabajo") as $key => $value) {
                            echo "<option value='" . $value . "'>" . $value . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input name="coleccion" type="text"></td>
                <td><input name="numero" type="number"></td>
                <td>
                    <select class="tipo" name="tipo" id="">
                        <option value="" disabled selected>Seleccione Tipo</option>
                        <?php
                        foreach ($tablaProducto->getEnum("tipo") as $key => $value) {
                            echo "<option value='" . $value . "'>" . $value . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select class="formato" name="formato" id="">
                        <option value="" disabled selected>Seleccione Formato</option>
                        <?php
                        foreach ($tablaProducto->getEnum("formato") as $key => $value) {
                            echo "<option value='" . $value . "'>" . $value . "</option>";
                        }
                        ?>

                    </select>
                    <!-- <input name="formato" type="text"> -->
                </td>
                <td><input name="paginas" type="number"></td>
                <td>
                    <select class="subtipo" name="subtipo">;
                        <option value='' disabled selected>Seleccione Género</option>;
                        <?php
                        foreach ($tablaProducto->getEnum("subtipo") as $key => $valor) {
                            echo "<option value='" . $valor . "'"
                                . ($valor == $value->subtipo ? 'selected' : '') .
                                ">" . $valor . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input name="editorial" type="text"></td>
                <td><input name="anio_publicacion" type="date"></td>

                <td>

                    <textarea name="sinopsis" id=""></textarea>
                </td>
                <td><input name="precio" type="number" step="0.01"></td>
                <td><input class="stock" name="stock" type="number"></td>
                <?php

                ?>
                </select></td>
                <td>
                    <input type="submit" value="Nuevo" class="btn btn-primary" name="nuevoProducto">
                </td>
                </tr>
            </table>
            <div>
                <input type="submit" value="Eliminar" class="btn" name="eliminarProducto">
                <input type="submit" value="Actualizar" class="btn" name="actualizarProducto">
            </div>
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
    <script src="./assets/js/cambioActionProducto.js"></script>


</body>

</html>