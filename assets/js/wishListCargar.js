document.addEventListener('DOMContentLoaded', async () => {
    const responseLang = await fetch("/assets/lang/es.json");
    const json = await responseLang.json();
    const responseProducto = await fetch('index.php?controller=WishList&action=listarWishlist');
    const productos = await responseProducto.json();
    if (document.querySelector(".containerProductosWishList")) {
        //Cargamos los productos que el usuario tiene en su wishlist
                console.log(json);
                console.log(productos);

                let lang = localStorage.getItem("lang");
                console.log(productos.length);
                const contenedor = document.createElement('div');
                contenedor.classList.add('productosWishList');
                contenedor.innerHTML = "";
                if (productos.length === 0) {
                    contenedor.innerHTML = `<p class="lang" data-lang="sinProductos">${json[lang]['wishList']['sinProductos']}</p>`;
                } else {
                    //recorremos el array de productos que tiene el usuario en su wishlist
                    //construimos el contenedor de productos
                    productos.forEach(producto => {
                        const contenedorProducto = document.createElement('div');
                        contenedorProducto.classList.add('producto');
                        contenedorProducto.innerHTML = `
                        <a class="Producto__borrar__boton" href="index.php?controller=WishList&action=eliminarProducto&isbn=${producto.isbn_13}"></a>
                        <img src="data:image/jpeg;base64,${producto.portada}" alt="${producto.nombre}">
                        <h2 class="Producto__info__titulo">${producto.nombre}</h2>
                        <h3 class="Producto__info__autor">${producto.nombreArtista} ${producto.apellido1} ${producto.apellido2}</h3>
                        <p class="Producto__info__precio">${producto.precio}€</p>
                        <a class="Producto__info__boton btnVerdePrimario lang" data-lang="verProducto" href="index.php?controller=ProductoDetalle&action=view&isbn=${producto.isbn_13}">${json[lang]['wishList']['verProducto']}</a>`;
                        //añadimos el contenedor al contenedor principal
                        contenedor.appendChild(contenedorProducto)
                    });
                }
                document.querySelector('.containerProductosWishList').appendChild(contenedor);

        //cada botón te debe de llevar a la página de detalle del producto

    }
});