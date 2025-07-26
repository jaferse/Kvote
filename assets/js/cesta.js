import { cargarIdioma, crearDialogo } from "./funcionesGenericas.js";
let carritosUsuarios = {};
let usuarioLogueadoId = -1; // Variable para almacenar el ID del usuario logueado
let carrito;

document.addEventListener('DOMContentLoaded', async function () {
    //obtenemos el json de idioma
    
    const data = await cargarIdioma();

    //obtenermos el login del usuario
    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    const user = await responseUser.json();
    usuarioLogueadoId = user.usernameId;

    //cargamos el json de idioma del navegador
    const lang = localStorage.getItem('lang');
    // let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    carritosUsuarios = JSON.parse(localStorage.getItem("carrito")) || {};
    carrito = carritosUsuarios[usuarioLogueadoId] || {};

    document.querySelector('.containerCesta>h1').innerHTML = `${data[lang]['carrito']['titulo']}`;
    document.querySelector('.comprar').textContent = data[lang]['carrito']['finalizarCompra'];

    //Si el carrito tiene productos, los mostramos
    if (Object.keys(carrito).length > 0) {
        let precio = 0;
        // Recorremos el carrito y mostramos los productos
        for (const key in carrito) {
            console.log(carrito[key]);

            let divProducto = document.createElement('div');
            divProducto.classList.add('productoCarrito');
            divProducto.setAttribute('data-isbn', key);
            divProducto.innerHTML = /*html*/ `
                <img src="data:image/jpeg;base64,${carrito[key].producto.portada}" alt="${carrito[key].producto.titulo}">
                <h3>${carrito[key].producto.nombre}</h3>
                <div class="contenido">
                <span class="lang" data-lang="autor">${data[lang]['carrito']['autor']}</span>
                ${carrito[key].producto.nombreArtista} ${carrito[key].producto.apellido1} ${carrito[key].producto.apellido2}
                </div> 
                <div class="contenido">
                <span class="lang" data-lang="precioUnitario">${data[lang]['carrito']['precioUnitario']}</span>${carrito[key].producto.precio} €</div>
                <div class="contenido">
                <label for="cantidad[${key}]"  class="lang" data-lang="cantidad">${data[lang]['carrito']['cantidad']}</label><input id="cantidad[${key}]" type="number" value="${carrito[key].cantidad}"  min="0" max="${carrito[key].producto.stock}">  </label>
                <span class="error_stock lang">Stock maximo</span>
                </div>
                <div class="contenido">
                <span class="lang" data-lang="importe">${data[lang]['carrito']['importe']}</span> <span class="importeProducto">${(carrito[key].producto.precio * carrito[key].cantidad).toFixed(2)} €</span>
                </div>
                <a class="btnEliminar lang" data-isbn="${key}">
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
            `;
            document.querySelector('.productos').appendChild(divProducto);

            // Acumulamos el precio totalprecio
            precio += carrito[key].producto.precio * carrito[key].cantidad;
            document.querySelector('.precioTotal').innerHTML = `<span class="lang" data-lang="subtotal">${data[lang]['carrito']['subtotal']}:</span> ${precio.toFixed(2)} €`;
        }

    }
    // Si el carrito está vacío, mostramos un mensaje
    else {
        console.log(lang);

        document.querySelector('.containerCesta').innerHTML =
            `<div class="cestaVacia">
                <img src='assets/img/libroCestaVacia${lang}.png'>
                <p class='lang' data-lang='sinProductos'>${data[lang]['carrito']['sinProductos']}</p>
            </div>`
    }
});



document.querySelector('.productos').addEventListener('change', function (e) {
    //Modificar la cantidad del producto
    if (e.target.matches('[id^="cantidad"]')) {
        let isbn = e.target.closest('.productoCarrito').getAttribute('data-isbn');
        let cantidad = parseInt(e.target.value);

        if (carrito[isbn]) {
            console.log(carrito[isbn]);
            // Actualizar la cantidad del producto en el carrito
            carrito[isbn].cantidad = cantidad;
            // Guardar el carrito actualizado en localStorage
            if (carrito[isbn].cantidad <= 0) {
                // Si la cantidad es 0 o menor, eliminar el producto del carrito       
                delete carrito[isbn];
                e.target.closest('.productoCarrito').remove();
            }
            // Verificar si la cantidad es mayor que el stock
            if (carrito[isbn] && carrito[isbn].cantidad >= carrito[isbn].producto.stock) {
                // Si la cantidad es mayor que el stock, mostrar un mensaje de error   

                e.target.value = carrito[isbn].producto.stock; // Restablecer al stock máximo
                carrito[isbn].cantidad = carrito[isbn].producto.stock; // Actualizar la cantidad en el carrito
                // Mostrar el mensaje de error
                e.target.parentElement.querySelector('.error_stock').style.display = 'inline';

            } else {
                // Si la cantidad es válida, ocultar el mensaje de error
                e.target.parentElement.querySelector('.error_stock').style.display = 'none';
            }
            carritosUsuarios[usuarioLogueadoId] = carrito; // Actualizar el carrito del usuario logueado

            localStorage.setItem("carrito", JSON.stringify(carritosUsuarios));
            // Actualizar el precio total
            actualizarPrecio();

        }

    }

})

document.querySelector('.productos').addEventListener('click', function (e) {
    //Borrar producto de la cesta
    if (e.target.closest('.btnEliminar')) {
        let isbn = e.target.closest('.btnEliminar').getAttribute('data-isbn');
        
        if (carrito[isbn]) {
            delete carrito[isbn];
            e.target.closest('.productoCarrito').remove();
            carritosUsuarios[usuarioLogueadoId] = carrito; // Actualizar el carrito del usuario logueado

            localStorage.setItem("carrito", JSON.stringify(carritosUsuarios));
            actualizarPrecio();
        }
    }
})

document.querySelector('.comprar').addEventListener('click', async function (e) {
    e.preventDefault();
    await comprar();
});


/**
 * Realiza la compra de los productos en el carrito.
 * Si no hay productos en el carrito, muestra un mensaje de alerta.
 * Si la compra es exitosa, limpia el carrito y muestra un mensaje de confirmación.
 * Si falla la compra, muestra un mensaje de error en la consola.
 */
async function comprar() {
  let carritoUsuarios = JSON.parse(localStorage.getItem("carrito")) || {};
    carrito = carritoUsuarios[usuarioLogueadoId] || {};
    console.log(carrito);

    if (Object.keys(carrito).length > 0) {
        try {
            // Redirigir a la página de compra
            const responseCompra = await fetch('index.php?controller=Cesta&action=comprar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(carrito)
            });
            const data = await responseCompra.json();
            console.log('Respuesta del servidor:', data);
            if (data.status === 'success') {
                // Si la compra fue exitosa, limpiar el carrito
                localStorage.removeItem("carrito");
                document.querySelector('.productos').innerHTML = ''; // Limpiar los productos mostrados
                document.querySelector('.precioTotal').textContent = 'Precio total: 0.00 €'; // Reiniciar el precio total
                let datos = {};
                datos['titulo'] = 'Compra realizada con exito';
                datos['mensaje'] = 'Compra realizada con exito';
                datos['mensajeAceptar'] = 'Aceptar';
                datos['mensajeCancelar'] = 'Ver Pedidos';
                datos['data'] = data;
                crearDialogo
                    (datos,
                        () => {
                            location.reload();
                        },
                        () => {
                             window.location.href = "index.php?controller=HistorialPedidos&action=view";
                        });
            } else {
                alert('Error en la compra: ' + (data.message || 'Respuesta inesperada'));
            }
        } catch (error) {
            console.error('Error al enviar el carrito:', error);
            alert('Ha ocurrido un error al realizar la compra. Intenta más tarde.');
        }

    } else {
        alert("No hay productos en la cesta para comprar.");
    }

}


/**
 * Actualiza el precio total de los productos en el carrito y muestra el resultado en 
 * la etiqueta con clase "precioTotal".
 */
function actualizarPrecio() {
    let precioTotal = 0;
    for (const key in carrito) {
        let precioUnitario = carrito[key].producto.precio * carrito[key].cantidad;
        precioTotal += carrito[key].producto.precio * carrito[key].cantidad;
        // Actualizar el importe del producto en el carrito
        let productoCarrito = document.querySelector(`.productoCarrito[data-isbn="${key}"]`);
        productoCarrito.querySelector('.importeProducto').textContent = precioUnitario.toFixed(2) + ' €';
    }
    // Mostrar el precio total actualizado
    document.querySelector('.precioTotal').textContent = `Precio total: ${precioTotal.toFixed(2)} €`;
    //Si el precio es 0 se recarga la pagina
    if (precioTotal === 0) {
        window.location.reload();
    }
}