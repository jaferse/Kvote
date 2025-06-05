document.addEventListener('DOMContentLoaded', function () {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    //Si el carrito tiene productos, los mostramos
    if (Object.keys(carrito).length > 0) {
        let precio = 0;
        // Recorremos el carrito y mostramos los productos
        for (const key in carrito) {
            // console.log(carrito[key]);

            let divProducto = document.createElement('div');
            divProducto.classList.add('productoCarrito');
            divProducto.setAttribute('data-isbn', key);
            divProducto.innerHTML = `
                <img src="data:image/jpeg;base64,${carrito[key].producto.portada}" alt="${carrito[key].producto.titulo}">
                <h3>${carrito[key].producto.nombre}</h3>
                <p>Autor: ${carrito[key].producto.nombreArtista} ${carrito[key].producto.apellido1} ${carrito[key].producto.apellido2}</p> 
                <p>Precio: ${carrito[key].producto.precio} €</p>
                <label for="cantidad[${key}]" >Cantidad: </label><input id="cantidad[${key}]" type="number" value="${carrito[key].cantidad}"  min="0">  </label>
                <a class="btnEliminar" data-isbn="${key}"></a>
            `;
            document.querySelector('.productos').appendChild(divProducto);

            // Acumulamos el precio totalprecio
            precio += carrito[key].producto.precio * carrito[key].cantidad;
            document.querySelector('.precioTotal').textContent = `Precio total: ${precio.toFixed(2)} €`;
        }

    }
    // Si el carrito está vacío, mostramos un mensaje
    else {
        document.querySelector('.containerCesta').innerHTML = `<p>No existen productos en la cesta</p>`
    }

});



document.querySelector('.productos').addEventListener('change', function (e) {
    //Modificar la cantidad del producto
    if (e.target.matches('[id^="cantidad"]')) {
        let isbn = e.target.closest('.productoCarrito').getAttribute('data-isbn');
        let cantidad = parseInt(e.target.value);
        let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
        if (carrito[isbn]) {
            // Actualizar la cantidad del producto en el carrito
            carrito[isbn].cantidad = cantidad;
            // Guardar el carrito actualizado en localStorage
            if (carrito[isbn].cantidad <= 0) {
                // Si la cantidad es 0 o menor, eliminar el producto del carrito
                delete carrito[isbn];
                e.target.closest('.productoCarrito').remove();
            }
            localStorage.setItem("carrito", JSON.stringify(carrito));
            // console.log(localStorage.getItem("carrito"));

            // Actualizar el precio total
            actualizarPrecio();

        }
    }

})

document.querySelector('.productos').addEventListener('click', function (e) {
    //Borrar producto de la cesta
    if (e.target.matches('.btnEliminar')) {
        let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
        if (carrito[e.target.getAttribute('data-isbn')]) {
            delete carrito[e.target.getAttribute('data-isbn')];
            e.target.closest('.productoCarrito').remove();
            localStorage.setItem("carrito", JSON.stringify(carrito));
            actualizarPrecio();
            console.log(carrito);
        }
    }
})

document.querySelector('.comprar').addEventListener('click', function (e) {

    e.preventDefault();
    comprar();
});


function comprar() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
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

function actualizarPrecio() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || {};
    let precioTotal = 0;
    for (const key in carrito) {
        precioTotal += carrito[key].producto.precio * carrito[key].cantidad;
    }
    // Mostrar el precio total actualizado
    document.querySelector('.precioTotal').textContent = `Precio total: ${precioTotal.toFixed(2)} €`;
}