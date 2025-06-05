document.addEventListener("DOMContentLoaded", () => {

    if (!localStorage.getItem("darkMode")) {
        localStorage.setItem("darkMode", "light");
    }
    document.querySelector('.darkMode__button').innerHTML = /*html*/
    `<i class="icon"></i>`;
    if (localStorage.getItem("darkMode") == "dark") {
        document.querySelector('.icon').classList.remove('icon-moon');
        document.querySelector('.icon').classList.add('icon-sun');
        cambiarModo();
    }else{
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
});


function cambiarModo() {
    //body
    document.querySelector('body').classList.toggle('body--Dark');

    //header
    let header = document.querySelector('.header');
    header.classList.toggle('header--dark');

    //Login
    let login = document.querySelector('.login');
    login.classList.toggle('login--dark');

    //Buscador
    let searchdark = document.querySelector('.search');
    searchdark.classList.toggle('search--dark');

    //Carro
    let carroDark = document.querySelector('.carro');
    carroDark.classList.toggle('carro--dark');

    //Fondo del titulo
    document.querySelectorAll('.main__bestSellers__title').forEach(titulo => {
        titulo.classList.toggle('title--dark');
    });

    //bordes tarjetas
    document.querySelectorAll('.main__bestSellers').forEach(tarjeta => {
        tarjeta.classList.toggle('bestSellers--dark');
    });

    //Footer
    document.querySelector('.footer').classList.toggle('footer--dark');

    //Tarjetas de productos
    document.querySelectorAll('.containerProductos__producto').forEach(tarjeta => {
        tarjeta.classList.toggle('containerProductos__producto--dark');
    });

    //formulario
    if (document.querySelector('.registro__contenedor')) {
        document.querySelector('.registro__contenedor').classList.toggle('contenerdor--dark');
        document.querySelector('.registro__title').classList.toggle('title--dark');
        document.querySelector('#botonRegistrar').classList.toggle('botonRegistrar--dark');
    }
}