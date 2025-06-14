import { convertirFormatoFecha } from './funcionesGenericas.js';
/**
 * Devuelve el ISBN13 de un producto desde la URL actual
 * @param {string} nombre - El nombre del par metro en la URL
 * @returns {string} El ISBN13 del producto
 * @throws {Error} Si no se encuentra el par metro en la URL
 */
function getISBN13(nombre) {
    let URL = new URLSearchParams(window.location.search);
    let isbn = URL.get("isbn");
    if (isbn) {
        return isbn;
    } else {
        console.error("Error: No se ha encontrado el ISBN en la URL.");
    }

}

/**
 * Agrega el producto actual a la lista de productos en el carrito
 * Si el producto ya está en el carrito, se incrementa la cantidad
 * Si el producto no está en el carrito, se agrega
 * @returns {void}
 */
function agregarProductoCarrito() {

    fetch(`index.php?controller=ProductoDetalle&action=getProducto&isbn=${getISBN13("ISBN")}`)
        .then(response => response.json())
        .then(producto => {

            // console.log(JSON.parse(localStorage.getItem("carrito")));

            let carrito = JSON.parse(localStorage.getItem("carrito")) || {};

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

            // Guardar el carrito actualizado en localStorage
            localStorage.setItem("carrito", JSON.stringify(carrito));

            // console.log(JSON.parse(localStorage.getItem("carrito")));
        })
}

function agregarProductoWishlist() {

    window.location.href = "index.php?controller=WishList&action=agregarProducto&isbn=" + getISBN13("ISBN");
}

// Cargar el producto al cargar la página
window.addEventListener('DOMContentLoaded', async () => {
    let descuento = 5;
    // console.log(getISBN13("ISBN"));
    const ContainerProducto = document.querySelector(".ContainerProducto");
    const response = await fetch('assets/lang/es.json');
    const dataLang = await response.json();
    let lang = localStorage.getItem("lang") || "es";
    fetch(`index.php?controller=ProductoDetalle&action=getProducto&isbn=${getISBN13("ISBN")}`)
        .then(response => response.json())
        .then(producto => {
            let fecha = convertirFormatoFecha(producto.anio_publicacion);
            // console.log(new Date(producto.anio_publicacion).getTime());
            document.querySelector('.Producto__img > img').src = `data:image/jpeg;base64,${producto.portada}`;
            document.querySelector('.Producto__info__titulo').textContent = producto.nombre;
            document.querySelector('.Producto__info__autor').textContent = `${producto.nombreArtista} ${producto.apellido1} ${producto.apellido2}`;//falta el autor
            document.querySelector('.Producto__info__sinopsis').textContent = producto.sinopsis;
            document.querySelector('.Producto__info__caracteristicas__publicacion').textContent = fecha;
            document.querySelector('.Producto__info__caracteristicas__publicacion').setAttribute('data-fecha', producto.anio_publicacion);
            document.querySelector('.Producto__info__caracteristicas__paginas').textContent = producto.paginas;
            document.querySelector('.Producto__info__caracteristicas__tipo').textContent = dataLang[lang]['producto']['Tipo'][producto.tipo];
            document.querySelector('.Producto__info__caracteristicas__tipo').setAttribute('data-lang', 'Tipo');
            document.querySelector('.Producto__info__caracteristicas__tipo').setAttribute('data-content', producto.tipo);
            document.querySelector('.Producto__info__caracteristicas__subtipo').textContent = dataLang[lang]['producto']['Subtipo'][producto.subtipo];
            document.querySelector('.Producto__info__caracteristicas__subtipo').setAttribute('data-lang', 'Subtipo');
            document.querySelector('.Producto__info__caracteristicas__subtipo').setAttribute('data-content', producto.subtipo);
            document.querySelector('.Producto__info__caracteristicas__formato').textContent = dataLang[lang]['producto']['Formato'][producto.formato];
            document.querySelector('.Producto__info__caracteristicas__formato').setAttribute('data-lang', 'Formato');
            document.querySelector('.Producto__info__caracteristicas__formato').setAttribute('data-content', producto.formato);
            document.querySelector('.Producto__info__caracteristicas__editorial').textContent = producto.editorial;
            document.querySelector('.Producto__info__precioComprar__precio__actual').textContent = (Math.ceil(producto.precio / 1.05));
            document.querySelector('.Producto__info__precioComprar__precio__anterior').textContent = producto.precio;
            document.querySelector('.Producto__info__precioComprar__precio__descuento').textContent = descuento + '%';

            document.querySelector('.Producto__comentarios__formulario>#isbn13').value = producto.isbn_13;
        });

    ContainerProducto.style.visibility = 'visible';

});

// Añadir un evento de clic a los botones de añadir a la cesta y wishlist
document.addEventListener('click', (e) => {

    if (e.target.matches('.botonCesta')) {
        //Añadir a la cesta
        fetch('index.php?controller=LogIn&action=verificarLogIn')
            .then(response => response.json())
            .then(datos => {
                // console.log("Datos: " + datos.logueado);
                if (datos.logueado) {
                    // Agregar al carrito
                    agregarProductoCarrito();
                } else {
                    //redirigir a la página de inicio de sesión
                    window.location.href = "index.php?controller=LogIn&action=view";
                }
            });
    }
    if (e.target.matches('.botonWishlist')) {
        fetch('index.php?controller=LogIn&action=verificarLogIn')
            .then(response => response.json())
            .then(datos => {
                // console.log("Datos: "+datos.logueado);
                if (datos.logueado) {
                    // Agregar al la wishlist
                    // console.log("Agregando a la wishlist");
                    agregarProductoWishlist();
                } else {
                    //redirigir a la página de inicio de sesión
                    window.location.href = "index.php?controller=LogIn&action=view";
                }
            });
    }

    // Eliminar mensaje de error si existe
    if (document.querySelector('.mensajeError')) {
        document.querySelector('.mensajeError').remove();
    }

});
