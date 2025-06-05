<nav class="subnavegador">
    <?php
    require_once("core/funcionesGenericas.php");
    // Obtener la URL actual
    $url_actual = $_SERVER['REQUEST_URI'];

    ?>
    <div class="breadcrumb">
        <a class="breadcrumb__home" href="/">
            <img src="./assets/img/homeBreadcrumbs.png" alt="Icono de casa">
        </a>
        <?php
        //En función de la URL actual, mostramos el icono correspondiente de las migas de pan
        if ($url_actual !== "/") {
            //sacamos la query string
            $query = parse_url($url_actual)['query'];
            // echo var_dump($query)."<br>";

            // Descomponemos la URL en sus partes
            parse_str($query, $params);

            switch ($params['controller'] . "|" . $params['action']) {

                case 'Catalogo|novedades':
                    echo "<img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                            <a class='breadcrumb__home' href='" . $url_actual . "'>
                                <img src='./assets/img/comicIcon.png' alt='Icono de casa'>
                            </a>";
                    break;

                case 'Catalogo|comic':
                    echo "<img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                            <a class='breadcrumb__home' href='" . $url_actual . "'>
                                <img src='./assets/img/comicIcon.png' alt='Icono de casa'>
                            </a>";
                    break;

                case 'Catalogo|libros':
                    echo "  <img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                                <a class='breadcrumb__home' href='" . $url_actual . "'>
                                    <img src='./assets/img/libroIcon.png' alt='Icono de casa'>
                                </a>";
                    break;

                case 'Nosotros|view':
                    echo "<img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                            <a class='breadcrumb__home' href='" . $url_actual . "'>
                                <img src='./assets/img/nosotros.png' alt='Icono de casa'>
                            </a>";
                    break;

                case  'SingIn|view':
                    echo " <img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                            <a class='breadcrumb__home' href='" . $url_actual . "'>
                                <img src='./assets/img/form.png' alt='Icono de casa'>
                            </a>";
                    break;

                case 'ProductoDetalle|view':
                    // Comprobamos si tenemos el parámetro 'isbn' en la URL
                    if (isset($params['isbn']) && !empty($params['isbn'])) {
                        if (comprobarSiEsComic($params['isbn'])) {
                            echo "<img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                            <a class='breadcrumb__home' href='index.php?controller=Catalogo&action=comic'>
                            <img src='./assets/img/comicIcon.png' alt='Icono de casa'>
                            </a>";
                        } else {
                            echo "<img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                            <a class='breadcrumb__home' href='index.php?controller=Catalogo&action=libros'>
                            <img src='./assets/img/libroIcon.png' alt='Icono de casa'>
                            </a>";
                        }
                        echo "  <img src='./assets/img/arrowRight.png' alt='Flecha hacia la derecha'>
                        <a class='breadcrumb__home' href='" . $url_actual . "'>
                        <img src='./assets/img/form.png' alt='Icono de casa'>
                        </a>";
                    }
                    break;
            }
        }

        ?>
    </div>
    <ul class="translate">
        <li>
            <a class="es"><img src="./assets/img/es.svg" alt="Bandera España"></a>
        </li>
        <li>
            <a class="en"><img src="./assets/img/en.svg" alt="Bandera Reino Unido"></a>
        </li>
        <li>
            <a class="ja"><img src="./assets/img/ja.svg" alt="Bandera Japón"></a>
        </li>
    </ul>
    <div class="darkMode">
        <a class="darkMode__button"></a>
    </div>
</nav>