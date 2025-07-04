<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Kvote, tu tienda de cómics en Ciudad Real. Encuentra cómics, libros y más para todos los públicos. Vive la pasión por la lectura y la fantasía.">
    <meta name="author" content="Kvote entertainment ©">
    <meta name="keywords" content="cómics, superhéroes, manga, novelas, libros">

    <!-- Open Graph -->
    <meta property="og:title" content="Kvote - Tu tienda de cómics en Ciudad Real">
    <meta property="og:description"
        content="Descubre cómics y libros para todos los públicos en Kvote. La mejor selección de historias te espera en Ciudad Real.">
    <meta property="og:image" content="/img/og_img.png">
    <meta property="og:url" content="https://jaferse.github.io">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Kvote - Tu tienda de cómics en Ciudad Real">
    <meta name="twitter:description"
        content="Explora cómics y libros para todas las edades en Kvote. Encuentra tus historias favoritas en Ciudad Real.">
    <meta name="twitter:image" content="/img/og_img.png">
    <meta name="twitter:site" content="@kvoteshop"> <!--Ficticia-->
    <title>Comics</title>
    <link rel="icon" type="image/x-icon" href="/img/Kvote.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Aladin&family=Fleur+De+Leah&family=Italianno&family=Kotta+One&family=Noto+Sans+Thai:wght@100..900&family=Playwrite+AU+VIC+Guides&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/normalice.css">
    <link rel="stylesheet" href="/css/main.css">
</head>


<body>
    <?php
    require_once("view/components/header.php");
    ?>
    <nav class="subnavegador">
        <div class="breadcrumb">
            <a class="breadcrumb__home" href="/index.html">
                <img src="/img/homeBreadcrumbs.png" alt="Icono de casa">
            </a>
            <img src="/img/arrowRight.png" alt="Flecha hacia la derecha">
            <a class="breadcrumb__home" href="/html/comic.html">
                <img src="/img/comicIcon.png" alt="Icono de casa">
            </a>
        </div>
        <ul class="translate">
            <li>
                <a class="es"><img src="/img/es.svg" alt="Bandera España"></a>
            </li>
            <li>
                <a class="en"><img src="/img/en.svg" alt="Bandera Reino Unido"></a>
            </li>
            <li>
                <a class="ja"><img src="/img/ja.svg" alt="Bandera Japón"></a>
            </li>
        </ul>
        <div class="darkMode">
            <a class="darkMode__button">Modo oscuro</a>
        </div>
    </nav>
    <main class="containerEditorial">
        <h1 class="containerEditorial__titulo">Publicamos tu manuscrito</h1>

        <section class="containerEditorial__primero seccion">
            <h2>Diseño de la portada</h2>

            <a class="containerEditorial__primero__opc opcion" data-valor="autodisenio">
                <div>
                    <img src="/img/editorial/portada/portada_Autodisenio.png" alt="Portada 1">
                    <h3>Ya tengo portada</h3>
                </div>
            </a>
            <a class="containerEditorial__primero__opc opcion" data-valor="portadista">
                <div>
                    <img src="/img/editorial/portada/Portada_Portadista.png" alt="Portada 1">
                    <h3>Contratar diseño</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
            </div>
        </section>
        <section class="containerEditorial__segundo seccion">
            <h2>Creación de Prólogo</h2>

            <a class="containerEditorial__segundo__opc opcion" data-valor="propio">
                <div>
                    <img src="/img/editorial/prologo/propio.png" alt="Portada 1">
                    <h3>Escribir el prólogo personalmente</h3>
                </div>
            </a>
            <a class="containerEditorial__segundo__opc opcion" data-valor="Encargar">
                <div>
                    <img src="/img/editorial/prologo/encargar.png" alt="Portada 1">
                    <h3> Encargar el prólogo a un escritor/editor.</h3>
                </div>
            </a>
            <a class="containerEditorial__segundo__opc opcion" data-valor="Celebre">
                <div>
                    <img src="/img/editorial/prologo/celebre.png" alt="Portada 1">
                    <h3>Prólogo por autor reconocido</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__tercero seccion">
            <h2>Tipo de Papel</h2>
            <a class="containerEditorial__tercero__opc opcion" data-valor="Blanco">
                <div>
                    <img src="/img/editorial/Papel/blanco.png" alt="Portada 1">
                    <h3>Blanco estándar</h3>
                </div>
            </a>
            <a class="containerEditorial__tercero__opc opcion" data-valor="Ahuesado">
                <div>
                    <img src="/img/editorial/Papel/ahuesado.png" alt="Portada 1">
                    <h3> Ahuesado o crema </h3>
                </div>
            </a>
            <a class="containerEditorial__tercero__opc opcion" data-valor="Brillante">
                <div>
                    <img src="/img/editorial/Papel/brillante.png" alt="Portada 1">
                    <h3> Brillante o satinado</h3>
                </div>
            </a>
            <a class="containerEditorial__tercero__opc opcion" data-valor="Reciclado">
                <div>
                    <img src="/img/editorial/Papel/reciclado.png" alt="Portada 1">
                    <h3> Reciclado</h3>
                </div>
            </a>
            <a class="containerEditorial__tercero__opc opcion" data-valor="Especial">
                <div>
                    <img src="/img/editorial/Papel/especial.png" alt="Portada 1">
                    <h3> Especial (texturizado, pergamino, algodón)</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__cuarto seccion">
            <h2>Tipo de Cubierta</h2>

            <a class="containerEditorial__cuarto__opc opcion" data-valor="Blanda">
                <div>
                    <img src="/img/editorial/formato/blanda.jpg" alt="Portada 1">
                    <h3>Tapa blanda</h3>
                </div>
            </a>
            <a class="containerEditorial__cuarto__opc opcion" data-valor="Dura">
                <div>
                    <img src="/img/editorial/formato/dura.jpg" alt="Portada 1">
                    <h3> Tapa dura </h3>
                </div>
            </a>
            <a class="containerEditorial__cuarto__opc opcion" data-valor="Sobrecubierta">
                <div>
                    <img src="/img/editorial/formato/sobrecubierta.jpg" alt="Portada 1">
                    <h3> Cubierta con sobrecubierta</h3>
                </div>
            </a>
            <a class="containerEditorial__cuarto__opc opcion" data-valor="Digital">
                <div>
                    <img src="/img/editorial/formato/digital.jpg" alt="Portada 1">
                    <h3> Edición digital</h3>
                </div>
            </a>
            <a class="containerEditorial__cuarto__opc opcion" data-valor="Combinado">
                <div>
                    <img src="/img/editorial/formato/combo.jpg" alt="Portada 1">
                    <h3> Paquete combinado</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__quinto seccion">
            <h2>Acabado de la cubierta</h2>

            <a class="containerEditorial__quinto__opc opcion" data-valor="Mate">
                <div>
                    <img src="/img/editorial/cubierta/mate.jpg" alt="Portada 1">
                    <h3>Mate</h3>
                </div>
            </a>
            <a class="containerEditorial__quinto__opc opcion" data-valor="Brillante">
                <div>
                    <img src="/img/editorial/cubierta/brillo.jpg" alt="Portada 1">
                    <h3>Brillante</h3>
                </div>
            </a>
            <a class="containerEditorial__quinto__opc opcion" data-valor="Soft-touch">
                <div>
                    <img src="/img/editorial/cubierta/soft.jpg" alt="Portada 1">
                    <h3>Soft-touch</h3>
                </div>
            </a>
            <a class="containerEditorial__quinto__opc opcion" data-valor="Relieve">
                <div>
                    <img src="/img/editorial/cubierta/relieve.jpg" alt="Portada 1">
                    <h3>Impresión en relieve</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__sexto seccion">
            <h2>Diseño de Contraportada</h2>

            <a class="containerEditorial__sexto__opc opcion" data-valor="personalizado">
                <div>
                    <img src="/img/editorial/disenioPortada/descripcion.jpg" alt="Portada 1">
                    <h3>Escribir un texto personalizado</h3>
                </div>
            </a>
            <a class="containerEditorial__sexto__opc opcion" data-valor="FotoAutor">
                <div>
                    <img src="/img/editorial/disenioPortada/foto.jpg" alt="Portada 1">
                    <h3> Incluir foto del autor</h3>
                </div>
            </a>
            <a class="containerEditorial__sexto__opc opcion" data-valor="Comentarios">
                <div>
                    <img src="/img/editorial/disenioPortada/resenia.jpg" alt="Portada 1">
                    <h3>Añadir comentarios o reseñas.</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__septimo seccion">
            <h2>Número de Ejemplares</h2>

            <a class="containerEditorial__septimo__opc opcion" data-valor="BajoDemanda">
                <div>
                    <img src="/img/editorial/ejemplares/3.jpg" alt="Portada 1">
                    <h3>Impresión bajo demanda</h3>
                </div>
            </a>
            <a class="containerEditorial__septimo__opc opcion" data-valor="TiradaCorta">
                <div>
                    <img src="/img/editorial/ejemplares/1.jpg" alt="Portada 1">
                    <h3>Tiradas cortas</h3>
                </div>
            </a>
            <a class="containerEditorial__septimo__opc opcion" data-valor="TiradaGrande">
                <div>
                    <img src="/img/editorial/ejemplares/2.jpg" alt="Portada 1">
                    <h3>Tiradas grandes</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__octavo seccion">
            <h2>Tamaño del Libro</h2>

            <a class="containerEditorial__octavo__opc opcion" data-valor="A5">
                <div>
                    <img src="/img/editorial/tamanio/a5.jpg" alt="Portada 1">
                    <h3>A5 (14,8 x 21 cm)</h3>
                </div>
            </a>
            <a class="containerEditorial__octavo__opc opcion" data-valor="B6">
                <div>
                    <img src="/img/editorial/tamanio/b6.jpg" alt="Portada 1">
                    <h3>B6 (12,5 x 19 cm)</h3>
                </div>
            </a>
            <a class="containerEditorial__octavo__opc opcion" data-valor="A4">
                <div>
                    <img src="/img/editorial/tamanio/a4.jpg" alt="Portada 1">
                    <h3>A4 (21 x 29,7 cm) </h3>
                </div>
            </a>
            <a class="containerEditorial__octavo__opc opcion" data-valor="Cuadrado">
                <div>
                    <img src="/img/editorial/tamanio/cuadrado.jpg" alt="Portada 1">
                    <h3>Cuadrado (21 x 21 cm)</h3>
                </div>
            </a>
            <a class="containerEditorial__octavo__opc opcion" data-valor="Personalizado">
                <div>
                    <img src="/img/editorial/tamanio/personalizado.jpg" alt="Portada 1">
                    <h3>Formato personalizado</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__noveno seccion">
            <h2>Encuadernación</h2>

            <a class="containerEditorial__noveno__opc opcion" data-valor="Cosida">
                <div>
                    <img src="/img/editorial/encuadernacion/cosida.jpg" alt="Portada 1">
                    <h3>Cosida</h3>
                </div>
            </a>
            <a class="containerEditorial__noveno__opc opcion" data-valor="Fresada">
                <div>
                    <img src="/img/editorial/encuadernacion/fresada.jpg" alt="Portada 1">
                    <h3>Fresada</h3>
                </div>
            </a>
            <a class="containerEditorial__noveno__opc opcion" data-valor="Espiral">
                <div>
                    <img src="/img/editorial/encuadernacion/wire.jpg" alt="Portada 1">
                    <h3>Wire-O o espiral</h3>
                </div>
            </a>
            <div class="navSeccion">
                <button class="verMas siguiente">Siguiente</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
        <section class="containerEditorial__decimo seccion">
            <h2>Precio total</h2>
            <table class="resumen">
                <tbody>
                    <tr>
                        <th>Caracteristica</th>
                        <th>Elegido</th>
                        <th>Precio</th>
                    </tr>
                    <tr id="primero"></tr>
                    <tr id="segundo"></tr>
                    <tr id="tercero"></tr>
                    <tr id="cuarto"></tr>
                    <tr id="quinto"></tr>
                    <tr id="sexto"></tr>
                    <tr id="septimo"></tr>
                    <tr id="octavo"></tr>
                    <tr id="noveno"></tr>
                    <tr id="precioTotal"></tr>
                </tbody>
            </table>
            <div class="navSeccion">
                <button class="verMas tramitar">Tramitar</button>
                <button class="verMas atras">Atrás</button>
            </div>
        </section>
    </main>

    <?php
    require_once("view/components/footer.php");
    ?>

    <script type="module" src="/js/lang.js"></script>
    <script src="/js/darkMode.js"></script>
    <script src="/js/animacionLogo.js"></script>
    <script src="/js/search.js"></script>
    <script src="/js/hamburguer.js"></script>
    <script src="/js/publicarManuscrito.js"></script>

</body>

</html>