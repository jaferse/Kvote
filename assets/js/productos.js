/**
 * Crea una tarjeta de un producto
 * @param {HTMLElement} containerProductos - Elemento que contiene todas las tarjetas de productos
 * @param {Object} producto - Objeto con la informacion del producto
 * @property {string} titulo - Titulo del producto
 * @property {string} autor - Autor del producto
 * @property {number} precio - Precio del producto
 * @property {string} formato - Formato del producto
 * @property {string} subtipo - Subtipo del producto
 * @property {string} portadaImg - URL de la imagen de portada del producto
 * @property {string} isbn - ISBN del producto
 */
function crearTarjeta(containerProductos, producto, json) {
    //creamos la sección
    let containerProductos__producto = document.createElement('section');
    containerProductos__producto.classList.add('containerProductos__producto');

    //creamos el div img
    let containerProductos__producto__img = document.createElement('div');
    containerProductos__producto__img.classList.add('containerProductos__producto__img');

    //Creamos la imagen de portada
    let portada = document.createElement('img');
    portada.src = `data:image/jpeg;base64,${producto.portada}`;
    portada.classList.add('containerProductos__producto__img__portada');
    portada.id = producto.isbn_13;
    portada.style.cursor = "pointer";

    //añadimos la portada a el div y el div a el contendor productos
    containerProductos__producto__img.appendChild(portada);
    containerProductos__producto.appendChild(containerProductos__producto__img);

    //Creamos el contenedor de info
    let containerProductos__producto__info = document.createElement('div');
    containerProductos__producto__info.classList.add('containerProductos__producto__info');

    //creamos el titulo
    let containerProductos__producto__info__titulo = document.createElement('h2');
    containerProductos__producto__info__titulo.classList.add('containerProductos__producto__info__titulo');
    containerProductos__producto__info__titulo.textContent = producto.titulo;

    //creamos el hr
    let hr = document.createElement('hr');

    //creamos p de precio
    let containerProductos__producto__info__precio = document.createElement('p');
    containerProductos__producto__info__precio.classList.add('containerProductos__producto__info__precio');
    containerProductos__producto__info__precio.textContent = producto.precio;
    //creamos p de autor
    let containerProductos__producto__info__autor = document.createElement('p');
    containerProductos__producto__info__autor.classList.add('containerProductos__producto__info__autor');
    containerProductos__producto__info__autor.textContent = `${producto.nombreArtista} ${producto.apellido1} ${producto.apellido2}`;

    //creamos boton
    let botonVermas = document.createElement('button');
    botonVermas.classList.add('verMas');
    botonVermas.classList.add('lang');
    botonVermas.setAttribute('data-lang', 'verMas');
    // console.log(json);
    let lang = localStorage.getItem('lang');
    botonVermas.textContent = json[lang]["producto"]["verMas"];

    //creamos div info adicional
    let containerProductos__producto__info__adicional = document.createElement('div');
    containerProductos__producto__info__adicional.classList.add('containerProductos__producto__info__adicional');

    let containerProductos__producto__info__adicional__Formato = document.createElement('p');
    containerProductos__producto__info__adicional__Formato.classList.add('containerProductos__producto__info__adicional__Formato');
    containerProductos__producto__info__adicional__Formato.classList.add(lang);
    containerProductos__producto__info__adicional__Formato.setAttribute('data-lang', 'formato');
    containerProductos__producto__info__adicional__Formato.innerText = " " + producto.formato;
    let containerProductos__producto__info__adicional__Tipo = document.createElement('p');
    containerProductos__producto__info__adicional__Tipo.classList.add('containerProductos__producto__info__adicional__Tipo');
    containerProductos__producto__info__adicional__Tipo.classList.add(lang);
    containerProductos__producto__info__adicional__Tipo.setAttribute('data-lang', 'tipo');
    containerProductos__producto__info__adicional__Tipo.innerText = producto.tipo;
    let containerProductos__producto__info__adicional__Paginas = document.createElement('p');
    containerProductos__producto__info__adicional__Paginas.classList.add('containerProductos__producto__info__adicional__Paginas');
    containerProductos__producto__info__adicional__Paginas.classList.add(lang);
    containerProductos__producto__info__adicional__Paginas.setAttribute('data-lang', 'nPaginas');
    containerProductos__producto__info__adicional__Paginas.innerText = producto.paginas;
    let containerProductos__producto__info__adicional__ISBN = document.createElement('p');
    containerProductos__producto__info__adicional__ISBN.classList.add('containerProductos__producto__info__adicional__ISBN');
    containerProductos__producto__info__adicional__ISBN.innerText = producto.isbn_13;


    containerProductos__producto__info__adicional.appendChild(containerProductos__producto__info__adicional__Formato);
    containerProductos__producto__info__adicional.appendChild(containerProductos__producto__info__adicional__Tipo);
    containerProductos__producto__info__adicional.appendChild(containerProductos__producto__info__adicional__Paginas);
    containerProductos__producto__info__adicional.appendChild(containerProductos__producto__info__adicional__ISBN);


    containerProductos__producto__info.appendChild(containerProductos__producto__info__titulo);
    containerProductos__producto__info.appendChild(containerProductos__producto__info__autor);
    containerProductos__producto__info.appendChild(containerProductos__producto__info__precio);
    containerProductos__producto__info.appendChild(botonVermas);
    containerProductos__producto__info.appendChild(containerProductos__producto__info__adicional);


    containerProductos__producto.appendChild(containerProductos__producto__info);
    containerProductos.appendChild(containerProductos__producto);

}

/**
 * Contruye un grid de productos a partir de una lista de productos y un contenedor
 * 
 * @param {array} listaProductos - lista de productos
 * @param {object} containerProductos - contenedor donde se va a renderizar el grid
 * @param {string} tipo - tipo de producto que se va a renderizar
 */
function contruirGridProductos(listaProductos, containerProductos, tipo, json) {

    listaProductos.forEach(producto => {
        crearTarjeta(containerProductos, producto, json);
    });

}
window.addEventListener('DOMContentLoaded', () => {
    const containerProductos = document.querySelector('.containerProductos');
    let parametros = new URLSearchParams(window.location.search);
    // console.log("Seccion",parametros.get("action"));
    let seccion = parametros.get("action");
    console.log();
    fetch("/assets/lang/es.json")
        .then(response => response.json())
        .then(json => {
            //Ponemos en el titulo la seccion en mayuscula la primera letra
            let seccionMayuscula = seccion.charAt(0).toUpperCase() + seccion.slice(1)
            fetch(`index.php?controller=Catalogo&action=get${seccionMayuscula}`)
                .then(response => response.json())
                .then(productos => {
                    // console.log(productos);

                    contruirGridProductos(productos, containerProductos, seccion, json);

                    const verMas = document.querySelectorAll('.verMas');


                    //Controlar el mostrar info
                    verMas.forEach(boton => {

                        boton.addEventListener('click', (e) => {
                            let lang = localStorage.getItem("lang");
                            //Si esta oculto se muestra y si está mostrado se oculta

                            if (boton.nextElementSibling.style.display == "block") {
                                boton.nextElementSibling.style.display = "none";
                            } else {
                                e.target.parentNode.parentNode.style.height = "auto";
                                boton.nextElementSibling.style.display = "block";
                            }
                            boton.classList.toggle('active');

                            boton.textContent = (boton.classList.contains('active')) ? json[lang]["producto"]["ocultar"] : json[lang]["producto"]["verMas"];

                        });
                    });
                })
                .catch(error => console.error('Error al cargar productos:', error));

        });

    containerProductos.addEventListener('click', (e) => {
        if (e.target.classList.contains('containerProductos__producto__img__portada')) {
            console.log(e.target.id);
            // document.cookie = `ISBN=${e.target.isbn_13};`;
            console.log("index.php?controller=Producto&action=view&isbn=" + e.target.id);

            window.location.href = "index.php?controller=ProductoDetalle&action=view&isbn=" + e.target.id;
        }
    });

});