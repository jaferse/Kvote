import { convertirFormatoFecha, getISBN13, cargarIdioma, tooltip, ocultarSkeleton } from './funcionesGenericas.js';

let carritosUsuarios;

/**
 * Agrega el producto actual a la lista de productos en el carrito
 * Si el producto ya está en el carrito, se incrementa la cantidad
 * Si el producto no está en el carrito, se agrega
 * @returns {void}
 */
async function agregarProductoCarrito(user, producto) {

    //obtenermos el login del usuario
    let usuarioLogueadoId = user.usernameId;

    //Tienes que diferenciar entre los carritos de los usuarios y el carrito del usuario logueado
    carritosUsuarios = JSON.parse(localStorage.getItem("carrito")) || {};

    //Inicializamos el carrito del usuario logueado
    let carrito = {}; // Carrito del usuario logueado

    // Si el carrito del usuario logueado ya existe, lo usamos
    if (carritosUsuarios[usuarioLogueadoId]) {
        carrito = carritosUsuarios[usuarioLogueadoId];
    }
    // Si el carrito del usuario logueado no existe, lo creamos
    else {
        carritosUsuarios[usuarioLogueadoId] = {};
        carrito = carritosUsuarios[usuarioLogueadoId];
    }
    if (carrito[producto.isbn_13]) {
        // Si el producto ya está en el carrito, incrementar la cantidad
        carrito[producto.isbn_13].cantidad++;
    } else {
        // Si el producto no está en el carrito, agregarlo
        carrito[producto.isbn_13] = {
            producto,
            cantidad: 1
        };
    }

    carritosUsuarios[usuarioLogueadoId] = carrito; // Actualizar el carrito del usuario logueado
    //Volcamos el contenido en el localStorage
    localStorage.setItem("carrito", JSON.stringify(carritosUsuarios));

}

function agregarProductoWishlist() {
    window.location.href = "index.php?controller=WishList&action=agregarProducto&isbn=" + getISBN13();
}

function ocultarTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        setTimeout(() => {
            tooltip.remove(); // o tooltip.style.display = 'none';
        }, 3000);
    }
}
let user;
let producto;
let darkMode = localStorage.getItem("darkMode") || "light";
// Cargar el producto al cargar la página
window.addEventListener('DOMContentLoaded', async () => {
    ocultarTooltip();
    let descuento = 5;
    const ContainerProducto = document.querySelector(".ContainerProducto");
    const dataLang = await cargarIdioma();
    let lang = localStorage.getItem("lang") || "es";
    //Obtenemos el login del usuario
    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    user = await responseUser.json();

    const responseProducto = await fetch(`index.php?controller=ProductoDetalle&action=getProducto&isbn=${getISBN13()}`);
    producto = await responseProducto.json();

    let fecha = convertirFormatoFecha(producto.anio_publicacion);
    document.querySelector('.Producto__img > img').src = `data:image/jpeg;base64,${producto.portada}`;
    document.querySelector('.Producto__info__titulo').textContent = producto.nombre;
    document.querySelector('.Producto__info__autor').innerHTML = `<a class="enlaceStyled theme--${darkMode}" href="index.php?controller=Catalogo&action=autor&parametro=${producto.nombreArtista}-${producto.apellido1}-${producto.apellido2}">${producto.nombreArtista} ${producto.apellido1} ${producto.apellido2}</a>`;
    document.querySelector('.Producto__info__sinopsis').textContent = producto.sinopsis;

    document.querySelector('.Producto__info__caracteristicas__publicacion>.info').textContent = fecha;
    document.querySelector('.Producto__info__caracteristicas__publicacion').setAttribute('data-fecha', producto.anio_publicacion);
    document.querySelector('.Producto__info__caracteristicas__publicacion>.svgContainer').innerHTML += /*html*/
        `<svg class="iconCalendar" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="fondo" d="M3 9H21M7 3V5M17 3V5M6 13H8M6 17H8M11 13H13M11 17H13M16 13H18M16 17H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>`;


    document.querySelector('.Producto__info__caracteristicas__paginas>.info').textContent = producto.paginas;
    document.querySelector('.Producto__info__caracteristicas__paginas>.svgContainer').innerHTML = /* html */
        `<svg class="iconSvg iconPaginas" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" transform="translate(4 3)">
                <path d="m11.5.5h-7c-1.1045695 0-2 .8954305-2 2v9c0 1.1045695.8954305 2 2 2h7c1.1045695 0 2-.8954305 2-2v-9c0-1.1045695-.8954305-2-2-2z"/>
                <path d="m2.5 2.5c-1.1045695 0-2 .8954305-2 2v8c0 1.6568542 1.34314575 3 3 3h6c1.1045695 0 2-.8954305 2-2"/>
            </g>
        </svg>`;


    document.querySelector('.Producto__info__caracteristicas__tipo>.info').innerHTML = `<a class="enlaceStyled theme--${darkMode}" href="index.php?controller=Catalogo&action=categoria&parametro=${producto.tipo}">${dataLang[lang]['producto']['Tipo'][producto.tipo]}</a>`;
    document.querySelector('.Producto__info__caracteristicas__tipo>.svgContainer').innerHTML = /*html*/
        `<svg class="iconTipo" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 3.99995C12.8839 2.91716 14.9355 2.15669 17.07 1.74995C17.551 1.63467 18.0523 1.63283 18.5341 1.74458C19.016 1.85632 19.4652 2.07852 19.8464 2.39375C20.2276 2.70897 20.5303 3.10856 20.7305 3.56086C20.9307 4.01316 21.0229 4.50585 21 4.99995V13.9999C20.9699 15.117 20.5666 16.1917 19.8542 17.0527C19.1419 17.9136 18.1617 18.5112 17.07 18.7499C14.9355 19.1567 12.8839 19.9172 11 20.9999" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.9995 3.99995C9.1156 2.91716 7.06409 2.15669 4.92957 1.74995C4.44856 1.63467 3.94731 1.63283 3.46546 1.74458C2.98362 1.85632 2.53439 2.07852 2.15321 2.39375C1.77203 2.70897 1.46933 3.10856 1.26911 3.56086C1.0689 4.01316 0.976598 4.50585 0.999521 4.99995V13.9999C1.0296 15.117 1.433 16.1917 2.14533 17.0527C2.85767 17.9136 3.83793 18.5112 4.92957 18.7499C7.06409 19.1567 9.1156 19.9172 10.9995 20.9999" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M11 21V4" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>`;
    document.querySelector('.Producto__info__caracteristicas__tipo').setAttribute('data-lang', 'Tipo');
    document.querySelector('.Producto__info__caracteristicas__tipo').setAttribute('data-content', producto.tipo);

    document.querySelector('.Producto__info__caracteristicas__subtipo>.info').innerHTML = `<a class="enlaceStyled theme--${darkMode}" href="index.php?controller=Catalogo&action=subtipo&parametro=${producto.subtipo}">${dataLang[lang]['producto']['Subtipo'][producto.subtipo]}</a>`;
    document.querySelector('.Producto__info__caracteristicas__subtipo').setAttribute('data-lang', 'Subtipo');
    document.querySelector('.Producto__info__caracteristicas__subtipo').setAttribute('data-content', producto.subtipo);
    document.querySelector('.Producto__info__caracteristicas__subtipo>.svgContainer').innerHTML = /*html*/
        `<svg class="iconSvg iconSubtipo" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 viewBox="0 0 512 512"  xml:space="preserve">
<style type="text/css">
	.st0{fill:#000000;}
</style>
<g>
	<path class="st0" d="M293.686,333.324c5.976,52.529,58.497,59.684,74.014,59.684c15.521,0,68.042-7.155,74.01-59.684
		c-9.545,8.358-40.582,22.691-74.01,22.691C334.276,356.014,303.239,341.681,293.686,333.324z"/>
	<path class="st0" d="M312.681,272.069c12.31,1.33,23.671,5.338,33.591,11.37c0.394-17.695-12.824-33.041-30.747-34.969
		c-17.827-1.92-33.926,10.126-37.423,27.344C288.894,272.189,300.622,270.778,312.681,272.069z"/>
	<path class="st0" d="M389.129,283.439c9.919-6.032,21.285-10.039,33.587-11.37c12.067-1.291,23.786,0.12,34.579,3.745
		c-3.498-17.218-19.596-29.264-37.42-27.344C401.948,250.398,388.73,265.744,389.129,283.439z"/>
	<path class="st0" d="M511.724,171.919c0,0-0.02-0.216-0.036-0.327l-0.02-0.104l-0.02-0.144c-0.948-6.86-5.975-12.389-13.05-13.106
		c-5.765-0.59-11.586,2.35-17.119,3.673c-11.405,2.693-22.97,4.74-34.535,6.462c-30.085,4.478-60.56,6.549-90.964,5.832
		c-23.604-0.55-47.223-2.621-70.552-6.278c-8.7-36.101-23.006-95.259-27.058-112.023c-0.82-3.402-1.43-8.724-8.29-3.792
		c-4.96,3.593-54.665,28.874-118.249,44.243C68.247,111.724,12.475,111.916,6.42,111c-8.346-1.275-6.466,3.744-5.641,7.146
		C5.133,136.16,21.294,203.039,29.7,237.777c20.496,84.87,111.994,128.117,164.213,115.489c11.242-2.717,22.918-8.573,34.125-16.939
		c11.282,46.108,43.136,86.902,84.714,109.784c13.413,7.378,28.077,12.979,43.311,15.027c14.935,2.023,29.942-0.167,44.14-5.02
		c27.938-9.56,52.665-28.213,71.624-50.649c18.481-21.886,31.731-48.227,37.172-76.408c2.506-12.964,2.848-25.934,2.848-39.073
		V186.977C511.848,182.029,512.262,176.842,511.724,171.919z M61.156,185.351c11.358,0.972,23.082-0.398,34.487-4.493
		c11.656-4.176,21.776-10.733,29.99-18.932c4.534,17.098-4.705,35.129-21.679,41.2C87.086,209.182,68.606,201.262,61.156,185.351z
		 M223.564,256.612c-13.808-2.852-33.539-3.991-52.84,0.685c-28.596,6.908-52.18,25.576-58.625,34.691
		c-5.744-46.156,37.694-63.134,50.98-66.354c10.202-2.47,40.001-5.832,60.485,12.629V256.612z M231.835,159.648
		c-1.932,3.928-4.581,7.466-7.844,10.406c-5.008,4.526-11.405,7.633-18.6,8.581c-17.875,2.327-34.324-9.489-38.108-26.794
		c11.07,3.554,23.046,4.764,35.328,3.171c12.019-1.57,23.082-5.705,32.734-11.76C235.564,149.083,234.289,154.677,231.835,159.648z
		 M488.574,284.937c0,12.708,0.16,25.337-2.079,37.91c-1.933,10.867-5.247,21.448-9.72,31.519c-0.056,0.104-0.112,0.231-0.164,0.358
		c-0.015,0.048-0.055,0.104-0.071,0.175c-0.088,0.183-0.164,0.374-0.251,0.557c-0.159,0.374-0.339,0.749-0.518,1.14
		c0.048-0.144,0.123-0.263,0.179-0.415c-11.354,24.644-29.67,46.164-51.892,61.66c-12.302,8.589-26.109,15.593-40.813,18.939
		c-13.732,3.155-27.284,1.825-40.57-2.701c-27.826-9.506-52.032-29.814-69.01-53.526c-13.286-18.564-22.277-40.076-25.496-62.576
		c-0.88-6.103-1.326-12.302-1.326-18.516V184.149c14.274,3.513,28.83,6.102,43.438,8.07c9.314,1.275,18.676,2.295,27.986,3.14
		c31.193,2.805,62.548,2.964,93.757,0.43c25.66-2.079,51.514-5.497,76.551-11.656V284.937z"/>
</g>
</svg>`;

    // document.querySelector('.Producto__info__caracteristicas__formato>.info').textContent = dataLang[lang]['producto']['Formato'][producto.formato];
    document.querySelector('.Producto__info__caracteristicas__formato>.info').innerHTML = `<a class="enlaceStyled theme--${darkMode}" href="index.php?controller=Catalogo&action=formato&parametro=${producto.formato}">${dataLang[lang]['producto']['Formato'][producto.formato]}</a>`;
    document.querySelector('.Producto__info__caracteristicas__formato').setAttribute('data-lang', 'Formato');
    document.querySelector('.Producto__info__caracteristicas__formato').setAttribute('data-content', producto.formato);
    document.querySelector('.Producto__info__caracteristicas__formato>.svgContainer').innerHTML = /* html */
        `<svg version="1.1" id="Uploaded to svgrepo.com" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 class="iconSvg iconFormato" viewBox="0 0 32 32" xml:space="preserve">
<style type="text/css">
	.feather_een{fill:#0B1719;}
</style>
<path class="feather_een" d="M4,5v22c0,1.657,1.343,3,3,3h18c1.657,0,3-1.343,3-3V5c0-1.657-1.343-3-3-3H7C5.343,2,4,3.343,4,5z
	 M21,27c0,1.103-0.897,2-2,2H7c-1.103,0-2-0.897-2-2V5c0-1.103,0.897-2,2-2h12c1.103,0,2,0.897,2,2V27z M27,27c0,1.103-0.897,2-2,2
	h-3.779C21.7,28.468,22,27.772,22,27v-2h1.5c0.276,0,0.5-0.224,0.5-0.5S23.776,24,23.5,24H22v-1h1.5c0.276,0,0.5-0.224,0.5-0.5
	S23.776,22,23.5,22H22v-1h1.5c0.276,0,0.5-0.224,0.5-0.5S23.776,20,23.5,20H22v-1h1.5c0.276,0,0.5-0.224,0.5-0.5S23.776,18,23.5,18
	H22v-1h1.5c0.276,0,0.5-0.224,0.5-0.5S23.776,16,23.5,16H22v-1h1.5c0.276,0,0.5-0.224,0.5-0.5S23.776,14,23.5,14H22v-1h1.5
	c0.276,0,0.5-0.224,0.5-0.5S23.776,12,23.5,12H22v-1h1.5c0.276,0,0.5-0.224,0.5-0.5S23.776,10,23.5,10H22V9h1.5
	C23.776,9,24,8.776,24,8.5S23.776,8,23.5,8H22V7h1.5C23.776,7,24,6.776,24,6.5S23.776,6,23.5,6H22V5c0-0.772-0.3-1.468-0.779-2H25
	c1.103,0,2,0.897,2,2V27z M17,6H9C8.448,6,8,6.448,8,7v6c0,0.552,0.448,1,1,1h8c0.552,0,1-0.448,1-1V7C18,6.448,17.552,6,17,6z
	 M17,13H9V7h8V13z M18,16.5c0,0.276-0.224,0.5-0.5,0.5h-9C8.224,17,8,16.776,8,16.5S8.224,16,8.5,16h9C17.776,16,18,16.224,18,16.5z
	 M18,22.5c0,0.276-0.224,0.5-0.5,0.5h-9C8.224,23,8,22.776,8,22.5S8.224,22,8.5,22h9C17.776,22,18,22.224,18,22.5z M18,20.5
	c0,0.276-0.224,0.5-0.5,0.5h-9C8.224,21,8,20.776,8,20.5S8.224,20,8.5,20h9C17.776,20,18,20.224,18,20.5z M18,18.5
	c0,0.276-0.224,0.5-0.5,0.5h-9C8.224,19,8,18.776,8,18.5S8.224,18,8.5,18h9C17.776,18,18,18.224,18,18.5z M14,24.5
	c0,0.276-0.224,0.5-0.5,0.5h-5C8.224,25,8,24.776,8,24.5S8.224,24,8.5,24h5C13.776,24,14,24.224,14,24.5z"/>
</svg>`;

    document.querySelector('.Producto__info__caracteristicas__editorial>.info').innerHTML = `<a class="enlaceStyled theme--${darkMode}" href="index.php?controller=Catalogo&action=editorial&parametro=${producto.editorial}">${producto.editorial}</a>`;
    // document.querySelector('.Producto__info__caracteristicas__editorial>.info').textContent = producto.editorial;
    document.querySelector('.Producto__info__caracteristicas__editorial>.svgContainer').innerHTML = /* html */
        `<svg class="iconSvg editorial" version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
        viewBox="-3.84 -3.84 71.68 71.68" enable-background="new 0 0 64 64" xml:space="preserve" fill="#000000" stroke="#000000" stroke-width="1.3439999999999999">
        <g stroke-width="0"/>
        <g stroke-linecap="round" stroke-linejoin="round"/>
        <g id="SVGRepo_iconCarrier"> 
        <g> 
            <path fill="#ffffff" d="M18,10v54h9V53c0-0.553,0.447-1,1-1h8c0.553,0,1,0.447,1,1v11h9V20V4c0-2.211-1.789-4-4-4H22 c-2.211,0-4,1.789-4,4V10z M34,9c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1v4c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1V9z M34,19c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1v4c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1V19z M34,29c0-0.553,0.447-1,1-1 h4c0.553,0,1,0.447,1,1v4c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1V29z M34,39c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1v4 c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1V39z M24,9c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1v4c0,0.553-0.447,1-1,1h-4 c-0.553,0-1-0.447-1-1V9z M24,19c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1v4c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1V19z M24,29c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1v4c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1V29z M24,39c0-0.553,0.447-1,1-1 h4c0.553,0,1,0.447,1,1v4c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1V39z"/> 
                    <rect x="26" y="30" fill="#ffffff" width="2" height="2"/> 
                    <rect x="26" y="40" fill="#ffffff" width="2" height="2"/> 
                    <rect x="29" y="54" fill="#ffffff" width="6" height="10"/> 
                    <rect x="8" y="50" fill="#ffffff" width="2" height="2"/> 
                    <rect x="26" y="10" fill="#ffffff" width="2" height="2"/> 
                    <rect x="26" y="20" fill="#ffffff" width="2" height="2"/> 
                    <rect x="36" y="20" fill="#ffffff" width="2" height="2"/> 
                    <rect x="36" y="10" fill="#ffffff" width="2" height="2"/> 
                    <rect x="36" y="30" fill="#ffffff" width="2" height="2"/> 
                    <rect x="36" y="40" fill="#ffffff" width="2" height="2"/> 
                    <rect x="8" y="40" fill="#ffffff" width="2" height="2"/> 
            <path fill="#ffffff" d="M16,10H4c-2.211,0-4,1.789-4,4v46c0,2.211,1.789,4,4,4h12V10z M12,53c0,0.553-0.447,1-1,1H7 c-0.553,0-1-0.447-1-1v-4c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1V53z M12,43c0,0.553-0.447,1-1,1H7c-0.553,0-1-0.447-1-1v-4 c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1V43z M12,33c0,0.553-0.447,1-1,1H7c-0.553,0-1-0.447-1-1v-4c0-0.553,0.447-1,1-1h4 c0.553,0,1,0.447,1,1V33z M11,24H7c-0.553,0-1-0.447-1-1v-4c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1v4 C12,23.553,11.553,24,11,24z"/> 
                <rect x="54" y="50" fill="#ffffff" width="2" height="2"/> 
                <rect x="54" y="40" fill="#ffffff" width="2" height="2"/> 
                <rect x="54" y="30" fill="#ffffff" width="2" height="2"/> 
            <path fill="#ffffff" d="M60,20H48v44h12c2.211,0,4-1.789,4-4V24C64,21.789,62.211,20,60,20z M58,53c0,0.553-0.447,1-1,1h-4 c-0.553,0-1-0.447-1-1v-4c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1V53z M58,43c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1v-4 c0-0.553,0.447-1,1-1h4c0.553,0,1,0.447,1,1V43z M58,33c0,0.553-0.447,1-1,1h-4c-0.553,0-1-0.447-1-1v-4c0-0.553,0.447-1,1-1h4 c0.553,0,1,0.447,1,1V33z"/> 
            <rect x="8" y="30" fill="#ffffff" width="2" height="2"/> 
            <rect x="8" y="20" fill="#ffffff" width="2" height="2"/> 
        </g> 
        </g>
    </svg>`;

    document.querySelector('.Producto__info__precioComprar__precio__actual').textContent = (Math.ceil(producto.precio / 1.05));
    document.querySelector('.Producto__info__precioComprar__precio__anterior').textContent = producto.precio;
    document.querySelector('.Producto__info__precioComprar__precio__descuento').textContent = '-'+descuento + '%';

    //Si el producto pertenece a una coleccion
    if (producto.coleccion && producto.coleccion !== 'Autoconclusivo') {
        let coleccion = document.createElement('li');
        coleccion.classList.add('Producto__info__caracteristicas__coleccion', lang);
        coleccion.innerHTML = `<p class="info"><a class="enlaceStyled theme--${darkMode}" href="index.php?controller=Catalogo&action=coleccion&parametro=${producto.coleccion}">${producto.coleccion} ${producto.numero}</a></p>
        <div class="svgContainer">
        <svg class="iconSvg" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none">
            <g class="contorno--fill">
                <path d="M6.75 8a.75.75 0 000 1.5h2.5a.75.75 0 000-1.5h-2.5z"/>
                <path fill-rule="evenodd" d="M0 2.75C0 1.784.784 1 1.75 1h12.5c.966 0 1.75.784 1.75 1.75v1.5c0 .698-.409 1.3-1 1.582v6.918A2.25 2.25 0 0112.75 15h-9.5A2.25 2.25 0 011 12.75V5.832A1.75 1.75 0 010 4.25v-1.5zm13.5 10V6h-11v6.75c0 .414.336.75.75.75h9.5a.75.75 0 00.75-.75zm1-8.5a.25.25 0 01-.25.25H1.75a.25.25 0 01-.25-.25v-1.5a.25.25 0 01.25-.25h12.5a.25.25 0 01.25.25v1.5z" clip-rule="evenodd"/>
            </g>
        </svg>
        </div>`;

        document.querySelector('.Producto__info__caracteristicas>ul').appendChild(coleccion);

    }
    //Si existe le damos el valor del ISBN
    if (document.querySelector('.Producto__comentarios__formulario>#isbn13')) {
        document.querySelector('.Producto__comentarios__formulario>#isbn13').value = producto.isbn_13;
    }

    //Desabilitar botón comprar si no hay stock del producto
    if (producto.stock <= 0) {
        document.querySelector('.botonCesta').disabled = true;
        document.querySelector('.botonCesta').classList.add('disabled');
        let sinStock = document.createElement('p');
        sinStock.classList.add('avisoSinStock', 'tagInfo');
        sinStock.textContent = 'Sin stock';
        document.querySelector('.Producto__info__precioComprar__tooltip').appendChild(sinStock);
    }

    //Añadir cartel para indicar que el producto está en preventa
    let anno = new Date(producto.anio_publicacion)
    if (anno >= new Date()) {
        let sinStock = document.createElement('p');
        sinStock.classList.add('preventa', 'tagInfo');
        sinStock.textContent = 'En preventa';
        document.querySelector('.Producto__info__precioComprar__tooltip').appendChild(sinStock);
    }

    if (localStorage.getItem("flash_msg")) {
        let mensaje = JSON.parse(localStorage.getItem("flash_msg"));
        tooltip(dataLang[lang]['wishList'][mensaje.message], mensaje.type, document.querySelector('.ContainerProducto'));
        localStorage.removeItem("flash_msg");
    }

    ContainerProducto.style.visibility = 'visible';

    ocultarSkeleton('block');
});

// Añadir un evento de clic a los botones de añadir a la cesta y wishlist
document.addEventListener('click', (e) => {
    //Si se pulsa el botón de añadir a la cesta
    if (e.target.matches('.botonCesta')) {
        //Si está logeado
        if (user.logueado) {
            // Agregar al carrito
            agregarProductoCarrito(user, producto);
            tooltip('Añadido a la cesta', 'exito', e.target.parentElement);
        } else {
            tooltip('Inicia sesión', 'warning', e.target.parentElement);
            //redirigir a la página de inicio de sesión
            // window.location.href = "index.php?controller=LogIn&action=view";
        }
    }
    //Si se pulsa el botón de añadir a la wishlist
    if (e.target.matches('.botonWishlist')) {
        //Si está logeado
        if (user.logueado) {
            // Agregar al la wishlist
            agregarProductoWishlist();
        } else {
            tooltip('Inicia sesión', 'warning', e.target.parentElement);
            //redirigir a la página de inicio de sesión
            // window.location.href = "index.php?controller=LogIn&action=view";
        }
    }

    // Eliminar mensaje de error si existe
    if (document.querySelector('.mensajeError')) {
        document.querySelector('.mensajeError').remove();
    }

});
