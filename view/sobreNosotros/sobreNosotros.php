<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="canonical" href="https://jaferse.github.io/html/sombreNosotros.html">
    <!-- Importamos links y metadatos -->
    <?php
    require_once("view/components/meta.php");
    ?>
    <title>Sobre Nosotros</title>
</head>

<body>
    <?php
    require_once("view/components/header.php");
    require_once("view/components/subMenu.php");
    ?>

    <main class="nosotros">
        <article class="welcome">
            <h1 class="lang" data-lang="title">Nosotros</h1>

        </article>
        <article class="nosotros__historia" itemscope itemtype="http://schema.org/AboutPage">
            <section class="nosotros__historia__text">
                <h2 class="lang" data-lang="title" itemprop="headline">Nuestra Historia</h2>
                <p class="lang" data-lang="parrafo1" itemprop="description">
                    Todo comenzó en un pequeño rincón de Internet, donde un grupo de apasionados del cómic se reunía en
                    un
                    foro para compartir opiniones, reseñas y consejos sobre tiendas que ofrecían esos ejemplares
                    difíciles
                    de conseguir y las importaciones de cómics raros provenientes de otros países. En ese espacio de
                    diálogo
                    nació Kvote.
                </p>
                <p class="lang" data-lang="parrafo2" itemprop="description">
                    Con el tiempo, la comunidad creció, y junto a ella surgió la inquietud de transformar ese foro en
                    algo
                    más ambicioso. Javier Fernández, el creador de Kvote, decidió dar el siguiente paso:
                    convertir la web en una tienda especializada que ayudara tanto a los novatos del cómic como a los
                    verdaderos aficionados a conseguir sus ejemplares soñados.
                </p>
                <p class="lang" data-lang="parrafo3" itemprop="description">
                    Hoy, Kvote es mucho más que una tienda online. Es el resultado de la pasión y el esfuerzo colectivo
                    de
                    una comunidad que vive el cómic en todas sus formas. Hemos recorrido un largo camino desde aquel
                    foro
                    inicial, y cada reseña, recomendación y debate ha contribuido a forjar la identidad de una
                    plataforma
                    que conecta a quienes desean descubrir o profundizar en este universo.
                </p>
            </section>
            <picture class="nosotros__historia__img">
                <img src="./assets/img/inicio.webp" alt="Imagen de un comic" itemprop="image">
            </picture>
        </article>
        <article class="nosotros__mision" itemscope itemtype="http://schema.org/AboutPage">
            <section class="nosotros__mision__text">

                <h2 class="lang" data-lang="title" itemprop="headline">Nuestra Mision</h2>
                <p class="lang" data-lang="parrafo1" itemprop="description">
                    En Kvote, nuestra misión es acompañarte en cada etapa de tu aventura en el mundo del cómic,
                    adaptándonos
                    a tus necesidades y gustos. Por ello, ofrecemos una experiencia pensada para cada tipo de lector:
                </p>
                <ul>
                    <li class="lang" data-lang="subseccion1" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo1" itemprop="name">Para los que empiezan:</h3>
                        Queremos ayudarte a dar tus primeros pasos en este apasionante universo. Te ofrecemos
                        recomendaciones
                        personalizadas y asesoramiento para que inicies tu experiencia de lectura con títulos y autores
                        que
                        se
                        adapten a tus intereses, permitiéndote descubrir el cómic de la manera más amena y segura.
                    </li>
                    <li class="lang" data-lang="subseccion2" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo2" itemprop="name">Para el lector medio:</h3>
                        Sabemos que hay quienes disfrutan del cómic de forma habitual sin buscar necesariamente
                        ediciones
                        exclusivas o rarezas. Para ti, Kvote ha seleccionado un catálogo equilibrado que combina los
                        clásicos y
                        las novedades más populares, garantizando calidad, accesibilidad y un servicio pensado para tu
                        consumo
                        diario. Así, disfrutarás de una oferta variada que se ajusta a tus expectativas y ritmo.
                    </li>
                    <li class="lang" data-lang="subseccion3" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo3" itemprop="name">Para los aficionados avanzados:</h3>
                        Reconocemos a aquellos verdaderos conocedores que buscan piezas únicas y difíciles de conseguir.
                        Nos
                        adentramos en el mundo de colecciones privadas e importaciones directas desde los países de
                        origen
                        del
                        cómic para ofrecerte títulos exclusivos y rarezas que enriquezcan tu colección y enciendan tu
                        pasión.
                    </li>
                </ul>
                <p class="lang" data-lang="parrafo3" itemprop="description">
                    Con este compromiso, en Kvote creemos que cada lector, sin importar su nivel de experiencia, merece
                    disfrutar del mejor universo del cómic. ¡Estamos aquí para guiarte, acompañarte y sorprenderte en
                    cada
                    lectura!
                </p>
            </section>
            <picture class="nosotros__mision__img">
                <img src="./assets/img/tiendaComic.webp" alt="Imagen de estantería de comic" itemprop="image">
            </picture>
        </article>
        <article class="nosotros__editorial" itemscope itemtype="http://schema.org/Organization">

            <section class="nosotros__editorial__text">
                <h2 class="lang" data-lang="title" itemprop="headline">Nuestra Editorial</h2>
                <p class="lang" data-lang="parrafo1" itemprop="description">
                    En Kvote creemos en el poder transformador del cómic y en la necesidad de impulsar nuevas voces. Por
                    ello,
                    hemos creado nuestra propia editorial, dedicada a la publicación de cómics locales de Ciudad Real y
                    sus
                    alrededores, así como al rescate de pequeños autores poco conocidos del resto de España e incluso de
                    otros
                    países.
                </p>
                <p class="lang" data-lang="parrafo2" itemprop="description">
                    Nuestra misión editorial es clara:
                </p>

                <ul>
                    <li class="lang" data-lang="subseccion1" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo1" itemprop="name">Impulsar el talento emergente:</h3>
                        Brindamos una plataforma para que los creadores locales y aquellos que han
                        pasado desapercibidos en el circuito convencional puedan ver sus obras publicadas y llegar a un
                        público más
                        amplio.
                    </li>
                    <li class="lang" data-lang="subseccion2" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo2" itemprop="name">Calidad en cada detalle:</h3>
                        Cuidamos todo el proceso creativo, desde el guion hasta la producción final,
                        asegurándonos de que cada cómic refleje la pasión y el esfuerzo de sus autores.

                    </li>
                    <li class="lang" data-lang="subseccion3" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo3" itemprop="name">Diversidad y originalidad:</h3>
                        Fomentamos una propuesta artística diversa, que rompa esquemas y aporte nuevas
                        miradas al universo del cómic.
                    </li>
                </ul>
                <p class="lang" data-lang="parrafo4" itemprop="description">
                    Trabajamos mano a mano con los creadores, ofreciéndoles asesoramiento personalizado, recursos y el
                    acompañamiento necesario para transformar sus ideas en obras únicas y de alta calidad.</p>
            </section>

            <picture class="nosotros__editorial__img">
                <img src="./assets/img/editorial.jpg" alt="Imagen de un comic" itemprop="image">
            </picture>
        </article>
        <article class="nosotros__talleres">
            <section class="nosotros__talleres__text">
                <h2 class="lang" data-lang="title" itemprop="headline">Talleres y Formación</h2>
                <p class="lang" data-lang="parrafo1" itemprop="description">
                    En Kvote estamos convencidos de que el futuro del cómic se construye compartiendo conocimientos y
                    experiencias. Por ello, hemos implantado una serie de talleres de aprendizaje diseñados para todos
                    aquellos
                    que deseen adentrarse en el arte de crear cómics, ya sea perfeccionando técnicas o aprendiendo
                    nuevos
                    métodos. Nuestros talleres abarcan diversas áreas:
                </p>

                <picture class="nosotros__talleres__img">
                    <img src="./assets/img/taller.jpg" alt="Imagen del taller" itemprop="image">
                </picture>
                <ul>
                    <li class="lang" data-lang="subseccion1" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo1" itemprop="name">Creación de Guiones:</h3>
                        Aprende a estructurar y desarrollar historias sólidas que enganchen a tus lectores
                        desde el primer bocadillo.
                    </li>
                    <li class="lang" data-lang="subseccion2" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo2" itemprop="name">Dibujo e Ilustración:</h3>
                        Mejora tus habilidades para dar vida a personajes y escenarios, dominando
                        tanto el dibujo tradicional como digital.
                    </li>
                    <li class="lang" data-lang="subseccion3" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo3" itemprop="name">Coloración y Entintado:</h3>
                        Descubre cómo el uso del color y el entintado pueden transformar tus viñetas,
                        aportando dinamismo y profundidad a tus obras.
                    </li>
                    <li class="lang" data-lang="subseccion4" itemprop="itemListElement">
                        <h3 class="lang" data-lang="subtitulo4" itemprop="name">Talleres de Mercado:</h3>
                        Conoce las claves para mover el cómic comercialmente. Expertos de grandes editoriales
                        te enseñarán estrategias para posicionar y comercializar tus creaciones en el competitivo mundo
                        del
                        cómic.
                    </li>
                </ul>

            </section>
            <section class="nosotros__talleres__colaboradores">
                <h2 class="lang" data-lang="title" itemprop="headline">Nuestros Profesores</h2>
                <div class="nosotros__talleres__colaboradores__img" itemscope itemtype="http://schema.org/Person">
                    <h3 class="lang" data-lang="subtitulo1" itemprop="name">Autor de "Arrugas" y "La casa"</h3>
                    <picture>
                        <img src="./assets/img/pacoRoca.jpg" alt="Imagen de la Casa de Paco Roca" itemprop="image">
                    </picture>
                </div>
                <div class="nosotros__talleres__colaboradores__img">
                    <h3 class="lang" data-lang="subtitulo2" itemprop="name">Autora de "Cénit" y "Satori"</h3>
                    <picture>
                        <img src="./assets/img/MariaMedem.jpg" alt="Imagen de Satori de Maria Medem" itemprop="image">
                    </picture>
                </div>
                <div class="nosotros__talleres__colaboradores__img">
                    <h3 class="lang" data-lang="subtitulo3" itemprop="name">Ilustradora de "Todo bajo el sol"</h3>

                    <picture>
                        <img src="./assets/img/AnaPenyas.jpg" alt="Imagen de Todo bajo el sol de Ana Penyas" itemprop="image">
                    </picture>
                </div>
                <div class="nosotros__talleres__colaboradores__img">
                    <h3 class="lang" data-lang="subtitulo4" itemprop="name">Dibujante de "Blacksad"</h3>
                    <picture>
                        <img src="./assets/img/juanjoGarrido.jpg" alt="Imagen de Blacksad de Juanjo Garrido" itemprop="image">
                    </picture>
                </div>
                <h4 itemprop="name">Juanjo Garrido</h4>
                <h4 itemprop="name">Paco Roca</h4>
                <h4 itemprop="name">Maria Medem</h4>
                <h4 itemprop="name">Ana Penyas</h4>
            </section>
        </article>
    </main>

    <?php
    require_once("view/components/footer.php");
    ?>
    <script type="module" src="./assets/js/lang.js"></script>
    <script src="./assets/js/darkMode.js"></script>
    <!-- <script src="./assets/js/animacionLogo.js"></script> -->
    <script src="./assets/js/search.js"></script>
    <script src="./assets/js/hamburguer.js"></script>
    <script src="./assets/js/animacionScroll.js"></script>
</body>

</html>