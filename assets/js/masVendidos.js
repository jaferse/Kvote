
import { ocultarSkeleton } from './funcionesGenericas.js';
window.addEventListener('DOMContentLoaded', async () => {

    //Borramos si existe cookies de pagina actual y seteamos la sección
    localStorage.removeItem('paginaActual');
    localStorage.setItem('seccion', 'index');

    //Recogemos los productos mas vendidos de comic y novela
    const responseComic = await fetch(`index.php?controller=Producto&action=getBestSellers&tipo=comic`);
    const comic = await responseComic.json();

    const responseLibro = await fetch(`index.php?controller=Producto&action=getBestSellers&tipo=libro`)
    const libros = await responseLibro.json();
    let productos = [comic, libros]
    // Ocultamos el skeleton
    ocultarSkeleton('grid');
    //Cogemos el contenedor de los productos
    let containerProductos = document.querySelectorAll('.main__bestSellers__portadas');
    //Recorremos los contenedores y los llenamos con los libros
    containerProductos.forEach((contenedor, index) => {
        construirBestSeller(contenedor, productos[index]);
    });
    document.addEventListener('click', (e) => {
        if (e.target.closest('.tarjetaProducto__enlace')) {
            e.preventDefault();
            console.log(e.target);
            window.location.href = e.target.closest('.tarjetaProducto__enlace').getAttribute('href');
        }
    });
});

/**
 * Le pasamos el contenedor y los productos y nos crea todas las tarjetas con los productos
 * @param {*} contenedor 
 * @param {*} productos 
 */
function construirBestSeller(contenedor, productos) {

    productos.forEach(producto => {
        const enlace = document.createElement('a');
        enlace.classList.add('tarjetaProducto__enlace');
        enlace.setAttribute('href', `index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}`);
        const tarjetaProducto = document.createElement('div');
        tarjetaProducto.classList.add('tarjetaProducto');
        tarjetaProducto.innerHTML = /*html */
            `<div class="tarjetaProducto__portada">
                    <img src="data:image/jpeg;base64,${producto.portada}" alt="Imagen de portada de ${producto.nombre}">
                </div>
                    <h2 class="tarjetaProducto__titulo">${producto.nombre}</h2>`;
        
        enlace.appendChild(tarjetaProducto);
        contenedor.appendChild(enlace);
    });
}

