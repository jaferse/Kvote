
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

});

/**
 * Le pasamos el contenedor y los productos y nos crea todas las tarjetas con los productos
 * @param {*} contenedor 
 * @param {*} productos 
 */
function construirBestSeller(contenedor, productos) {

    productos.forEach(producto => {

        const tarjetaProducto = document.createElement('div');
        tarjetaProducto.classList.add('tarjetaProducto');
        tarjetaProducto.innerHTML = `<a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}">
                    <img src="data:image/jpeg;base64,${producto.portada}" alt="Imagen de portada de ${producto.nombre}">
                </a>
                <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}">${producto.nombre}</a></h3>`;
        contenedor.appendChild(tarjetaProducto);
    });
}