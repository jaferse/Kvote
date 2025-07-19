import { convertirFormatoFecha, getISBN13, cargarIdioma, tooltip } from './funcionesGenericas.js';

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
    //Si existe le damos el valor del ISBN
    if (document.querySelector('.Producto__comentarios__formulario>#isbn13')) {
        document.querySelector('.Producto__comentarios__formulario>#isbn13').value = producto.isbn_13;
    }

    //Desabilitar botón comprar si no hay stock del producto
    if (producto.stock <= 0) {
        document.querySelector('.botonCesta').disabled = true;
        document.querySelector('.botonCesta').classList.add('disabled');
        let sinStock= document.createElement('p');
        sinStock.classList.add('avisoSinStock');
        sinStock.textContent = 'Sin stock';
        document.querySelector('.Producto__info__precioComprar__tooltip').appendChild(sinStock);
    }
    
    if (localStorage.getItem("flash_msg")) {
       let mensaje = JSON.parse(localStorage.getItem("flash_msg"));
        tooltip(dataLang[lang]['wishList'][mensaje.message], mensaje.type, document.querySelector('.ContainerProducto'));
        localStorage.removeItem("flash_msg");
    }

    ContainerProducto.style.visibility = 'visible';

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
