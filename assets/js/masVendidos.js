
window.addEventListener('DOMContentLoaded', async () => {
    //Cogemos el contenedor de los productos
    containerProductos = document.querySelectorAll('.main__bestSellers__portadas');

    //Recogemos los productos mas vendidos de comic y novela
    const responseComic = await fetch(`index.php?controller=Producto&action=getBestSellers&tipo=comic`);
    const comic = await responseComic.json();

    const responseLibro = await fetch(`index.php?controller=Producto&action=getBestSellers&tipo=libro`)
    const libros = await responseLibro.json();
    let productos = [comic, libros]
    //Recorremos los contenedores y los llenamos con los libros
    containerProductos.forEach((contenedor, index) => {
        construirBestSeller(contenedor, productos[index]);
    });
    document.addEventListener('click', (e) => {
        // console.log(e.target.closest('.tarjetaProducto__enlace'));
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
                    <h3 class="tarjetaProducto__titulo">${producto.nombre}</h3>`;
        // tarjetaProducto.innerHTML = `<a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}">
        //             <img src="data:image/jpeg;base64,${producto.portada}" alt="Imagen de portada de ${producto.nombre}">
        //         </a>
        //         <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}">${producto.nombre}</a></h3>`;
        enlace.appendChild(tarjetaProducto);
        contenedor.appendChild(enlace);
    });
}

