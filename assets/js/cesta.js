let carritosUsuarios = {};
let usuarioLogueadoId = -1; // Variable para almacenar el ID del usuario logueado
let carrito
document.addEventListener('DOMContentLoaded', async function () {
    //obtenemos el json de idioma
    const response = await fetch('/assets/lang/es.json');
    const data = await response.json();

    //obtenermos el login del usuario
    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    const user = await responseUser.json();
    usuarioLogueadoId = user.usernameId;

    //cargamos el json de idioma del navegador
    const lang = localStorage.getItem('lang');
    // let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    carritosUsuarios = JSON.parse(localStorage.getItem("carrito")) || {};
    carrito = carritosUsuarios[usuarioLogueadoId] || {};
    // console.log(carritosUsuarios);
    // console.log(usuarioLogueadoId);
    // console.log(carrito);

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
            divProducto.innerHTML = `
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
                <a class="btnEliminar lang" data-isbn="${key}"></a>
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
        console.log(carrito);
        
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

        //Si no hay nada en el carrito se recarga la pagina
        if (Object.keys(carrito).length <= 0) {
            window.location.reload();
        }
    }

})

document.querySelector('.productos').addEventListener('click', function (e) {
    //Borrar producto de la cesta
    if (e.target.matches('.btnEliminar')) {
        if (carrito[e.target.getAttribute('data-isbn')]) {
            delete carrito[e.target.getAttribute('data-isbn')];
            e.target.closest('.productoCarrito').remove();
            carritosUsuarios[usuarioLogueadoId] = carrito; // Actualizar el carrito del usuario logueado

            localStorage.setItem("carrito", JSON.stringify(carritosUsuarios));
            actualizarPrecio();
        }
        if (Object.keys(carrito).length <= 0) {
            window.location.reload();
        }
    }
})

document.querySelector('.comprar').addEventListener('click', function (e) {
    e.preventDefault();
    comprar();
});


/**
 * Realiza la compra de los productos en el carrito.
 * Si no hay productos en el carrito, muestra un mensaje de alerta.
 * Si la compra es exitosa, limpia el carrito y muestra un mensaje de confirmación.
 * Si falla la compra, muestra un mensaje de error en la consola.
 */
function comprar() {
    carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    if (Object.keys(carrito).length > 0) {

        // Redirigir a la página de compra
        fetch('index.php?controller=Cesta&action=comprar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(carrito)
        })
            .then(response => response.json())  // O response.json()
            .then(data => {
                console.log(typeof data);
                console.log('Respuesta del servidor:', data.status);
                if (data.status === 'success') {
                    // Si la compra fue exitosa, limpiar el carrito
                    localStorage.removeItem("carrito");
                    document.querySelector('.productos').innerHTML = ''; // Limpiar los productos mostrados
                    document.querySelector('.precioTotal').textContent = 'Precio total: 0.00 €'; // Reiniciar el precio total
                    alert('Compra realizada con exito');
                }
            }).catch(error => {
                console.error('Error al enviar el carrito:', error);
            });
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
}