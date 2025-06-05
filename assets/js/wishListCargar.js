document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector(".containerProductosWishList")) {
        //Cargamos los productos que el usuario tiene en su wishlist
        fetch('index.php?controller=WishList&action=listarWishlist')
            .then(response => response.json())
            .then(productos => {
                console.log(productos.length);
                const contenedor = document.createElement('div');
                contenedor.classList.add('productosWishList');
                if (productos.length === 0) {
                     contenedor.innerHTML =`<p>No existen productos en la cesta</p>`;
                }else{
                    //recorremos el array de productos que tiene el usuario en su wishlist
                    //construimos el contenedor de productos
                    productos.forEach(producto => {
                        contenedor.innerHTML = `
                        <a class="Producto__borrar__boton" href="index.php?controller=WishList&action=eliminarProducto&isbn=${producto.isbn_13}"></a>
                        <img src="data:image/jpeg;base64,${producto.portada}" alt="${producto.nombre}">
                        <h2 class="Producto__info__titulo">${producto.nombre}</h2>
                        <h3 class="Producto__info__autor">${producto.nombreArtista} ${producto.apellido1} ${producto.apellido2}</h3>
                        <p class="Producto__info__precio">${producto.precio}€</p>
                        <a class="Producto__info__boton" href="index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}">Ver Producto</a>`;
                        //añadimos el contenedor al contenedor principal
                    });
                }
                document.querySelector('.containerProductosWishList').appendChild(contenedor);
            });





        //cada botón te debe de llevar a la página de detalle del producto

    }
});