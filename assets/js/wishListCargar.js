import { cargarIdioma } from './funcionesGenericas.js';
document.addEventListener('DOMContentLoaded', async () => {
    const darkMode=localStorage.getItem('darkMode');
    const json = await cargarIdioma();
    const responseProducto = await fetch('index.php?controller=WishList&action=listarWishlist');
    const productos = await responseProducto.json();
    if (document.querySelector(".containerProductosWishList")) {
        //Cargamos los productos que el usuario tiene en su wishlist
        console.log(json);
        console.log(productos);

        let lang = localStorage.getItem("lang");
        console.log(productos.length);
        const contenedor = document.createElement('div');
        contenedor.classList.add('productosWishList');
        contenedor.innerHTML = "";
        if (productos.length === 0) {
            //libroWishListVaciaes
            contenedor.innerHTML =
                `<div class="cestaVacia">
                <p class='lang' data-lang='sinProductos'>${json[lang]['wishList']['sinProductos']}</p>
                <img src='assets/img/libroWishListVacia${lang}.png'>
        </div>`
        } else {
            //recorremos el array de productos que tiene el usuario en su wishlist
            //construimos el contenedor de productos
            productos.forEach(producto => {
                const contenedorProducto = document.createElement('div');
                contenedorProducto.classList.add('producto');
                contenedorProducto.innerHTML = /*html */`
                        <a class="Producto__borrar__boton" href="index.php?controller=WishList&action=eliminarProducto&isbn=${producto.isbn_13}">
                           <svg class="iconSvg" viewBox="-3 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                <title>trash</title>
                                <desc>Created with Sketch Beta.</desc>
                                <defs>
                            </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                    <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-259.000000, -203.000000)" fill="#000000">
                                        <path d="M282,211 L262,211 C261.448,211 261,210.553 261,210 C261,209.448 261.448,209 262,209 L282,209 C282.552,209 283,209.448 283,210 C283,210.553 282.552,211 282,211 L282,211 Z M281,231 C281,232.104 280.104,233 279,233 L265,233 C263.896,233 263,232.104 263,231 L263,213 L281,213 L281,231 L281,231 Z M269,206 C269,205.447 269.448,205 270,205 L274,205 C274.552,205 275,205.447 275,206 L275,207 L269,207 L269,206 L269,206 Z M283,207 L277,207 L277,205 C277,203.896 276.104,203 275,203 L269,203 C267.896,203 267,203.896 267,205 L267,207 L261,207 C259.896,207 259,207.896 259,209 L259,211 C259,212.104 259.896,213 261,213 L261,231 C261,233.209 262.791,235 265,235 L279,235 C281.209,235 283,233.209 283,231 L283,213 C284.104,213 285,212.104 285,211 L285,209 C285,207.896 284.104,207 283,207 L283,207 Z M272,231 C272.552,231 273,230.553 273,230 L273,218 C273,217.448 272.552,217 272,217 C271.448,217 271,217.448 271,218 L271,230 C271,230.553 271.448,231 272,231 L272,231 Z M267,231 C267.552,231 268,230.553 268,230 L268,218 C268,217.448 267.552,217 267,217 C266.448,217 266,217.448 266,218 L266,230 C266,230.553 266.448,231 267,231 L267,231 Z M277,231 C277.552,231 278,230.553 278,230 L278,218 C278,217.448 277.552,217 277,217 C276.448,217 276,217.448 276,218 L276,230 C276,230.553 276.448,231 277,231 L277,231 Z" id="trash" sketch:type="MSShapeGroup">
                            </path>
                                    </g>
                                </g>
                            </svg>
                        </a>
                        <img src="data:image/jpeg;base64,${producto.portada}" alt="${producto.nombre}">
                        <h2 class="Producto__info__titulo">${producto.nombre}</h2>
                        <h3 class="Producto__info__autor">${producto.nombreArtista} ${producto.apellido1} ${producto.apellido2}</h3>
                        <p class="Producto__info__precio">${producto.precio}€</p>
                       ${((darkMode=='dark')?'<div class="enlaceBotonSmall theme--dark">':'<div class="enlaceBotonSmall">')}
                        <a class="Producto__info__boton lang" data-lang="verProducto" href="index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}">${json[lang]['wishList']['verProducto']}</a>
                        </div>`;
                //añadimos el contenedor al contenedor principal
                contenedor.appendChild(contenedorProducto)
            });
        }
        document.querySelector('.containerProductosWishList').appendChild(contenedor);

        //cada botón te debe de llevar a la página de detalle del producto

    }
});