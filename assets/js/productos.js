import { cargarIdioma } from './funcionesGenericas.js';

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
    const darkMode = localStorage.getItem('darkMode')
    //creamos la sección
    let containerProductos__producto = document.createElement('section');
    ((darkMode == 'dark') ?
        containerProductos__producto.classList.add('containerProductos__producto', 'theme--dark')
        : containerProductos__producto.classList.add('containerProductos__producto'));

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
    botonVermas.classList.add('verMas', 'lang', 'btnPrimario');
    // botonVermas.classList.add();
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

/**
 * Hace una peticion a la api para obtener los productos de una seccion
 * 
 * @param {string} seccion - seccion que se va a obtener, puede ser "libros" o "comic" o "novedades"
 * @param {number} page - numero de pagina que se va a obtener, por defecto es 1
 * @returns {object} objeto con la respuesta de la api
 */
async function sacarProductos(seccion, page = 1) {
    //Ponemos en el titulo la seccion en mayuscula la primera letra
    let seccionMayuscula = seccion.charAt(0).toUpperCase() + seccion.slice(1)
    const responseProductos = await fetch(`index.php?controller=Catalogo&action=get${seccionMayuscula}&page=${page}`);
    const productos = await responseProductos.json();
    return productos;
}



function construirPaginacion(productosRespuesta, seccion, paginaActual) {
    let seccionMayuscula = seccion.charAt(0).toUpperCase() + seccion.slice(1)
    let listaPaginacion = document.createElement('div');
    (localStorage.getItem('darkMode') == 'dark') ?
        listaPaginacion.classList.add('paginacion', 'theme--dark')
        :listaPaginacion.classList.add('paginacion');

    let paginas = Math.ceil(productosRespuesta['total'] / productosRespuesta['productoPaginas']);
    for (let i = 1; i <= paginas; i++) {
        let a = document.createElement('a');
        a.textContent = i;
        if (i == paginaActual) {
            a.classList.add('active');
        }
        a.classList.add('numeroPaginacion');
        a.setAttribute('data-page', i);
        a.setAttribute('href', `index.php?controller=Catalogo&action=${seccionMayuscula}&page=${i}`);
        listaPaginacion.appendChild(a);
    }
    document.querySelector('.container').appendChild(listaPaginacion);
}


window.addEventListener('DOMContentLoaded', async () => {
    let container = document.querySelector('.container');
    const containerProductos = document.querySelector('.containerProductos');
    let parametros = new URLSearchParams(window.location.search);
    let seccion = parametros.get("action");
    let paginaActual = 1;

    //Si no se ha recargado la pagina se mantiene la pagina actual
    if (sessionStorage.getItem("seccion") === seccion) {
        paginaActual = sessionStorage.getItem("paginaActual") || 1;
    }
    sessionStorage.setItem("seccion", seccion);

    // Nos traemos el json de los textos de traducción
    const json = await cargarIdioma();

    let productosRespuesta = await sacarProductos(seccion, paginaActual);
    let productos = productosRespuesta['productos'];
    let totalProductos = productosRespuesta['total'];

    contruirGridProductos(productos, containerProductos, seccion, json);

    const verMas = document.querySelectorAll('.verMas');

    construirPaginacion(productosRespuesta, seccion, paginaActual);

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

    //Redirigir al detalle del producto al hacer click en la imagen
    containerProductos.addEventListener('click', (e) => {
        if (e.target.classList.contains('containerProductos__producto__img__portada')) {
            window.location.href = "index.php?controller=ProductoDetalle&action=view&isbn=" + e.target.id;
        }
    });

    container.addEventListener('click', async (e) => {

        if (e.target.classList.contains('numeroPaginacion')) {
            // console.log(e.target);
            e.preventDefault();
            sessionStorage.setItem("paginaActual", e.target.getAttribute('data-page'));
            e.target.parentNode.querySelectorAll('.active').forEach(element => {
                element.classList.remove('active');
            })
            e.target.classList.add('active');
            let productosRespuesta = await sacarProductos(seccion, e.target.getAttribute('data-page'));
            let productos = productosRespuesta['productos'];
            let totalProductos = productosRespuesta['total'];
            containerProductos.innerHTML = '';

            contruirGridProductos(productos, containerProductos, seccion, json);
        }
    });

});