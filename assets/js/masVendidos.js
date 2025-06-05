
window.addEventListener('DOMContentLoaded', () => {
    //Cogemos el contenedor de los productos
    containerProductos = document.querySelectorAll('.main__bestSellers__portadas');
    
    //Recogemos los productos mas vendidos de comic y novela
    const masVendidosComic = fetch(`index.php?controller=Producto&action=getBestSellers&tipo=comic`)
        .then(response => response.json())
        .then(comic => {
            containerProductos[0].innerHTML = `
        
            <div class="tarjetaProducto">
                <a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${comic[0].isbn_13}">
                    <img src="data:image/jpeg;base64,${comic[0].portada}" alt="Imagen de portada de ${comic[0].nombre}">
                </a>
                <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${comic[0].isbn_13}">${comic[0].nombre}</a></h3>
            </div>
            <div class="tarjetaProducto">
                <a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${comic[1].isbn_13}">
                    <img src="data:image/jpeg;base64,${comic[1].portada}" alt="Imagen de portada de ${comic[1].nombre}">
                </a>
                <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${comic[1].isbn_13}">${comic[1].nombre}</a></h3>
            </div>
            <div class="tarjetaProducto">
                <a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${comic[2].isbn_13}">
                    <img src="data:image/jpeg;base64,${comic[2].portada}" alt="Imagen de portada de ${comic[2].nombre}">
                </a>
                <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${comic[2].isbn_13}">${comic[2].nombre}</a></h3>
            </div>
        `;
        })
    const masVendidosLibro = fetch(`index.php?controller=Producto&action=getBestSellers&tipo=libro`)
        .then(response => response.json())
        .then(libros => {
            containerProductos[1].innerHTML = `
            <div class="tarjetaProducto">
                        <a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${libros[0].isbn_13}">
                            <img src="data:image/jpeg;base64,${libros[0].portada}" alt="Imagen de portada de ${libros[0].nombre}">
                        </a>
                        <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${libros[0].isbn_13}">${libros[0].nombre}</a></h3>
                    </div>
                    <div class="tarjetaProducto">
                        <a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${libros[1].isbn_13}">
                            <img src="data:image/jpeg;base64,${libros[1].portada}" alt="Imagen de portada de ${libros[1].nombre}">
                        </a>
                        <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${libros[1].isbn_13}">${libros[1].nombre}</a></h3>
                    </div>
                    <div class="tarjetaProducto">
                        <a class="tarjetaProducto__portada" href="index.php?controller=ProductoDetalle&action=view&isbn=${libros[2].isbn_13}">
                            <img src="data:image/jpeg;base64,${libros[2].portada}"
                                alt="Imagen de portada de ${libros[2].nombre}">
                        </a>
                        <h3 class="tarjetaProducto__titulo"><a href="index.php?controller=ProductoDetalle&action=view&isbn=${libros[2].isbn_13}">${libros[2].nombre}</a></h3>
                    </div>`;
        })
});