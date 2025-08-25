<!DOCTYPE html>
<html lang="es">

<head>
  <?php
  require_once("view/components/meta.php");
  ?>
  <title>Kvote Tienda de Comics</title>
</head>

<body>
  <?php
  require_once("view/components/header.php");
  require_once("view/components/subMenu.php");
  ?>
  <div class="containerMain">
    <main class="ContainerProducto">
      <article class="Producto">
        <div class="Producto__img">
          <img src="./assets/img/portadas/sinPortada.avif" alt="Portada">
        </div>
        <div class="Producto__info">
          <h2 class="Producto__info__titulo">Título</h2>
          <h3 class="Producto__info__autor">Autor</h3>
          <p class="Producto__info__sinopsis"></p>
          <div class="Producto__info__caracteristicas">
            <ul>
              <li class="Producto__info__caracteristicas__publicacion lang">
                <p class="info"></p>
                <div class="svgContainer"></div>
              </li>
              <li class="Producto__info__caracteristicas__paginas">
                <p class="info"></p>
                <div class="svgContainer"></div>
              </li>
              <li class="Producto__info__caracteristicas__tipo lang">
                <p class="info"></p>
                <div class="svgContainer"></div>
              </li>
              <li class="Producto__info__caracteristicas__subtipo lang">
                <p class="info"></p>
                <div class="svgContainer"></div>
              </li>
              <li class="Producto__info__caracteristicas__formato lang">
                <p class="info"></p>
                <div class="svgContainer"></div>
              </li>
              <li class="Producto__info__caracteristicas__editorial">
                <p class="info"></p>
                <div class="svgContainer"></div>
              </li>
              <!-- <li class="Producto__info__caracteristicas__coleccion"></li> -->
            </ul>
          </div>
          <div class="Producto__info__precioComprar">
            <div class="Producto__info__precioComprar__precio">
              <span class="Producto__info__precioComprar__precio__actual"></span>
              <span class="Producto__info__precioComprar__precio__descuento"></span>
              <span class="Producto__info__precioComprar__precio__anterior"></span>
            </div>
            <div class="Producto__info__precioComprar__tooltip">
              <button class="Producto__info__precioComprar__boton botonCesta btn  btnPrimario">Añadir a la cesta</button>
            </div>
            <div class="Producto__info__precioWishlist__tooltip">
              <button class="Producto__info__precioComprar__boton botonWishlist btn btnSecundario">Añadir a wishlist</button>
              <?php
              if (isset($_SESSION['mensajeErrorWishlist'])) {
                echo "<div class='tooltip warning'>" . $_SESSION['mensajeErrorWishlist'] . "</div>";
                unset($_SESSION['mensajeErrorWishlist']);
              }
              ?>
            </div>
          </div>


        </div>
      </article>
      <article class="Producto__comentarios">
        <h2 class="Producto__comentarios__titulo lang" data-lang="titulo">Comentarios</h2>

        <?php
        if (isset($_SESSION['username'])) {
          echo "<form method='post' class='Producto__comentarios__formulario' id='formNuevoComentario'>";
          echo "<div class='Producto__comentarios__formulario__titulo'>";
          echo "<input class='Producto__comentarios__formulario__titulo__input lang' data-lang='tituloComentario' name='titulo' id='titulo' maxlength='100' placeholder='' required>";
          echo "</div>";
          echo "<div>";
          echo "    <textarea class='Producto__comentarios__formulario__texto lang nuevoComentario' data-lang='escribeComentario' name='comentario' placeholder='' required></textarea>";
          echo "</div>";
          echo "    <button type='submit' class='Producto__comentarios__formulario__boton lang btn btnPrimario' id='newComment' data-lang='enviarComentario'></button>";
          echo "<input type='hidden' name='isbn13' id='isbn13' value=''>";
          echo "</form>";
        } else {
          echo "<div class='Producto__comentarios__nologueado'>";
          echo '<a href="index.php?controller=LogIn&action=view" class="Producto__comentarios__formulario__boton lang" data-lang="registrate"></a>';
          echo "</div>";
        }
        ?>
        <div class="Producto__comentarios__lista">
          <!-- Aquí se cargarán los comentarios -->
        </div>
      </article>

    </main>
    <div id="content" class="cardSkeleton" style="height: 70rem;">
      <div class="skeleton image" style="width: 100%; height: 100%; margin: 0 auto; border-radius: 18px;"></div>
    </div>
  </div>
  <?php
  require_once("view/components/footer.php");
  ?>

  <script src="./assets/js/darkMode.js"></script>
  <script src="./assets/js/search.js"></script>
  <script src="./assets/js/hamburguer.js"></script>
  <script type="module" src="./assets/js/lang.js"></script>
  <script type="module" src="./assets/js/comentarios.js"></script>
  <script type="module" src="./assets/js/cargarProducto.js"></script>
</body>

</html>