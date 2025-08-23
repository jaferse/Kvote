import { convertirFormatoFecha, ocultarSkeleton } from './funcionesGenericas.js';
document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('index.php?controller=HistorialPedidos&action=listarPedidos');
    const pedidos = await response.json();
    const darkMode = localStorage.getItem('darkMode');
    construirGridPedidos(pedidos);
});

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('detallePedido')) {
        if (e.target.parentElement.querySelector('.detalleCompra').style.display == 'grid') {
            e.target.parentElement.querySelector('.detalleCompra').style.display = 'none';
        } else {
            e.target.parentElement.querySelector('.detalleCompra').style.display = 'grid';
        }
    }
})

async function construirGridPedidos(pedidos) {
    let containerPedidos = document.querySelector('.containerPedidos')
    const darkMode = localStorage.getItem('darkMode');

    pedidos.forEach(pedido => {
        let compra = document.createElement('div');
        console.log(pedido);
        
        compra.classList.add('compra');
        let formatoFecha = convertirFormatoFecha(pedido.compra.fechaCompra, true);
        compra.innerHTML = `
            <p class="fecha lang" data-fecha="${pedido.compra.fechaCompra}">${formatoFecha}</p>
            <p class="idPedido">${pedido.compra.idCompra}</p>
            <p class="nTarjeta">${pedido.compra.nTarjeta}</p>
            <p class="direccion">
            ${pedido.compra.idDireccion.pais} <br>
            ${pedido.compra.idDireccion.provincia} <br>
            ${pedido.compra.idDireccion.nombreLocalidad} <br>
            CP: ${pedido.compra.idDireccion.codigo_postal} <br>
            C/ ${pedido.compra.idDireccion.calle} <br>
            Nº ${pedido.compra.idDireccion.numero} <br>
            Piso: ${pedido.compra.idDireccion.piso}${pedido.compra.idDireccion.puerta}
            </p>
            <p class="precioTotal">${pedido.compra.totalCompra}€</p>
            <a class="detallePedido btn btnPrimario lang theme--${darkMode}" data-lang="botonDetalle">Ver Detalle</a>
        `;
        let divDetalleCompra = document.createElement('div');
        divDetalleCompra.classList.add('detalleCompra');
        divDetalleCompra.innerHTML = `
            <p class="isbn13">ISBN</p>
            <p class="tituloProducto lang" data-lang="tituloProducto">Titulo</p>
            <p class="autor lang" data-lang="autor">Autor</p>
            <p class="precioUnitario lang" data-lang="precioUnitario">Precio Unitario</p>
            <p class="unidades lang" data-lang="unidades">Unidades</p>
            <p class="subPrecio lang" data-lang="subtotal">Subtotal</p>
            `;
        // console.log(pedido.detalle);
        let index = 0;
        for (const key in pedido.detalle) {
            fetch(`index.php?controller=ProductoDetalle&action=getProducto&isbn=${pedido.detalle[key].isbn13}`)
                .then(response => response.json())
                .then(producto => {

                    divDetalleCompra.innerHTML += `
                <p class="isbn13">${pedido.detalle[key].isbn13}</p>
                <p class="tituloProducto">${producto.nombre}</p>
                <p class="autor">${producto.nombreArtista} ${producto.apellido1} ${producto.apellido2}</p>
                <p class="precioUnitario">${pedido.detalle[key].precioUnitario}€</p>
                <p class="unidades">${pedido.detalle[key].unidades}</p>
                <p class="subPrecio">${pedido.detalle[key].precioUnitario * pedido.detalle[key].unidades}€</p>
                `;
                    if (index < Object.keys(pedido.detalle).length - 1) {
                        divDetalleCompra.innerHTML += '<hr>';
                    }
                    compra.appendChild(divDetalleCompra);
                    index++;
                })

        }

        containerPedidos.appendChild(compra);
    });

    ocultarSkeleton('block');
}
