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
        document.querySelector('body').classList.toggle('body--Dark');
    }

    //header
    if (document.querySelector('.header')) {
        let header = document.querySelector('.header');
        header.classList.toggle('header--dark');
    }

    //Login
    if (document.querySelector('.login')) {
        let login = document.querySelector('.login');
        login.classList.toggle('login--dark');
    }

    //Buscador
    if (document.querySelector('.search')) {
        let searchdark = document.querySelector('.search');
        searchdark.classList.toggle('search--dark');
    }

    //Carro
    if (document.querySelector('.carro')) {
        let carroDark = document.querySelector('.carro');
        carroDark.classList.toggle('carro--dark');
    }

    //Fondo del titulo
    if (document.querySelector('.main__bestSellers__title')) {
        document.querySelectorAll('.main__bestSellers__title').forEach(titulo => {
            titulo.classList.toggle('title--dark');
        });
    }

    //bordes tarjetas
    if (document.querySelector('.main__bestSellers')) {
        document.querySelectorAll('.main__bestSellers').forEach(tarjeta => {
            tarjeta.classList.toggle('bestSellers--dark');
        });
    }

    //Footer
    if (document.querySelector('.footer')) {
        document.querySelector('.footer').classList.toggle('footer--dark');
    }

    //Tarjetas de productos
    if (document.querySelector('.containerProductos__producto')) {
        document.querySelectorAll('.containerProductos__producto').forEach(tarjeta => {
            tarjeta.classList.toggle('containerProductos__producto--dark');
        });
    }

    //formulario
    if (document.querySelector('.registro__contenedor')) {
        document.querySelector('.registro__contenedor').classList.toggle('contenerdor--dark');
        document.querySelector('.registro__title').classList.toggle('title--dark');
        document.querySelector('#botonRegistrar').classList.toggle('botonRegistrar--dark');
    }

    //menu login
    if (document.querySelector('.menuLogin')) {
        document.querySelector('.menuLogin').classList.toggle('menuLogin--dark');
    }

    //paginación
    if (document.querySelector('.paginacion')) {
        document.querySelector('.paginacion').classList.toggle('paginacion--dark');
    }

    //Contenedor de pedidos
    if (document.querySelector('.containerPedidos')) {
        document.querySelector('.containerPedidos').classList.toggle('containerPedidos--dark');
    }

    //Contenedor de perfil
    if (document.querySelector('.perfilContainer')) {
        document.querySelector('.perfilContainer').classList.toggle('theme--dark');
    }

    if (document.querySelector('.btnRojo')) {
        document.querySelectorAll('.btnRojo').forEach(btn => {
            btn.classList.toggle('theme--dark');
        });
        
    }
}