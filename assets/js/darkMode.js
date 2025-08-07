document.addEventListener("DOMContentLoaded", () => {

    if (!localStorage.getItem("darkMode")) {
        localStorage.setItem("darkMode", "light");
    }
    if (document.querySelector('.darkMode__button')) {
        document.querySelector('.darkMode__button').innerHTML = /*html*/
            `<i class="icon"></i>`;
        if (localStorage.getItem("darkMode") == "dark") {
            document.querySelector('.icon').classList.remove('icon-moon');
            document.querySelector('.icon').classList.add('icon-sun');
            cambiarModo();
        } else {
            document.querySelector('.icon').classList.remove('icon-sun');
            document.querySelector('.icon').classList.add('icon-moon');

        }

        /**
         * Evento click
         */
        document.querySelector('.darkMode__button').addEventListener('click', () => {
            if (localStorage.getItem("darkMode") == "dark") {
                localStorage.setItem("darkMode", "light")
                document.querySelector('.icon').classList.add('icon-moon');
                document.querySelector('.icon').classList.remove('icon-sun');
            } else {
                localStorage.setItem("darkMode", "dark")
                document.querySelector('.icon').classList.add('icon-sun');
                document.querySelector('.icon').classList.remove('icon-moon');
            }
            cambiarModo();
        });
    }
});


function cambiarModo() {
    //body
    if (document.querySelector('body')) {
        document.querySelector('body').classList.toggle('theme--Dark');
    }

    //header
    if (document.querySelector('.header')) {
        let header = document.querySelector('.header');
        header.classList.toggle('theme--dark');
    }

    //Buscador
    if (document.querySelector('.search')) {
        let searchdark = document.querySelector('.search');
        searchdark.classList.toggle('theme--dark');
    }

    //Fondo del titulo
    if (document.querySelector('.main__bestSellers__title')) {
        document.querySelectorAll('.main__bestSellers__title').forEach(titulo => {
            titulo.classList.toggle('theme--dark');
        });
    }

    //bordes tarjetas
    if (document.querySelector('.main__bestSellers')) {
        document.querySelectorAll('.main__bestSellers').forEach(tarjeta => {
            tarjeta.classList.toggle('theme--dark');
        });
    }

    //Footer
    if (document.querySelector('.footer')) {
        document.querySelector('.footer').classList.toggle('theme--dark');
    }

    //Tarjetas de productos
    if (document.querySelector('.containerProductos__producto')) {
        document.querySelectorAll('.containerProductos__producto').forEach(tarjeta => {
            tarjeta.classList.toggle('theme--dark');
        });
    }

    //formulario
    if (document.querySelector('.registro__contenedor')) {
        document.querySelector('.registro__contenedor').classList.toggle('theme--dark');
        document.querySelector('.registro__title').classList.toggle('theme--dark');
    }

    //menu login
    if (document.querySelector('.menuLogin')) {
        document.querySelector('.menuLogin').classList.toggle('theme--dark');
    }

    //paginación
    if (document.querySelector('.paginacion')) {
        document.querySelector('.paginacion').classList.toggle('theme--dark');
    }

    //Contenedor de pedidos
    if (document.querySelector('.containerPedidos')) {
        document.querySelector('.containerPedidos').classList.toggle('theme--dark');
    }

    //Contenedor de perfil
    if (document.querySelector('.perfilContainer')) {
        document.querySelector('.perfilContainer').classList.toggle('theme--dark');
    }

    // btn
    if (document.querySelector('.btn')) {
        document.querySelectorAll('.btn').forEach(btn => {
            btn.classList.toggle('theme--dark');
        });
    }

    //botones enlace
    if (document.querySelector('.enlaceBoton')) {
        document.querySelectorAll('.enlaceBoton').forEach(btn => {
            btn.classList.toggle('theme--dark');
        });
    }

    //Borde producto en detalle
    if (document.querySelector('.ContainerProducto')) {
        document.querySelector('.ContainerProducto').classList.toggle('theme--dark');
    }

    //Nosotros
    if (document.querySelector('.nosotros')) {
        document.querySelector('.nosotros').classList.toggle('theme--dark');
    }

    //Migas de pan
    if (document.querySelector('.breadcrumb')) {
        document.querySelector('.breadcrumb').classList.toggle('theme--dark');
    }

    //Cesta
    if(document.querySelector('.containerCesta')) {
        document.querySelector('.containerCesta').classList.toggle('theme--dark');
        ;
    }

    //whislist
    if(document.querySelector('.containerProductosWishList')) {
        document.querySelector('.containerProductosWishList').classList.toggle('theme--dark');
    }

    if(document.querySelector('.enlaceBotonSmall')) {
        document.querySelectorAll('.enlaceBotonSmall').forEach(btn => {
            btn.classList.toggle('theme--dark');
        })
    }

    if(document.querySelector('select')){
        document.querySelectorAll('select').forEach(select => {
            select.classList.toggle('theme--dark');
        })
    }
    if (document.querySelector('.progress-container')) {
        document.querySelector('.progress-container').classList.toggle('theme--dark');
        
    }

    if (document.querySelector('.perfilContainer .theme--dark')) {
        document.querySelectorAll('.perfilContainer .formGroup').forEach(grupo => {
            grupo.querySelectorAll('input:not([type="button"])').forEach(input => {
                input.classList.toggle('theme--dark');
            })
        });
        
    }
    if (document.querySelector('.iconSvg')) {
        document.querySelectorAll('.iconSvg').forEach(svg => {
                svg.classList.toggle('theme--dark');
        });
    }
    if (document.querySelector('.mainAdmin')) {
        document.querySelector('.mainAdmin').classList.toggle('theme--dark');
    }
}