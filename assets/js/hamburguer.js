const menuHamburguesa = document.querySelector('.menuHamburguesa');

menuHamburguesa.addEventListener('click', () => {
    const menu = document.querySelector('.nav__menu');
    
    if (menu.classList.contains("open")) {
        menu.classList.remove("open");
        menu.style.animation = "slideOut 0.3s forwards";
    } else {
        menu.classList.add("open");
        menu.style.animation = "slideIn 0.3s forwards";
    }

});


window.addEventListener("resize", () => {
    const menu = document.querySelector('.nav__menu');
    if (window.innerWidth > 768) {
        menu.classList.remove("open");
        menu.style.animation = "none"; // Quita la animación
        menu.style.opacity = "1"; // Asegura que sea visible en pantallas grandes
        // menu.style.left = "auto"; // Lo posiciona correctamente
    }
});


