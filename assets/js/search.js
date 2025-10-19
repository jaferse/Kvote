const lupa = document.querySelector('.search > label');
const input = document.querySelector('.search>input');
lupa.addEventListener('click', (e) => {
    if (window.matchMedia("(max-width: 992px)").matches) {
        if (input.style.display == "flex") {
            input.style.display = "none";
        } else {
            input.style.display = "flex";
        }
    } else {
        input.style.display = "flex";
    }    
    if (e.target.closest('.buscarLabel')) {
        const input= document.querySelector('.search>input');
        if (input.value != '') {
            location.href = `index.php?controller=Catalogo&action=buscar&parametro=${input.value}`
        }
    }
})
window.addEventListener('resize', () => {
    if (window.matchMedia("(min-width: 992px)").matches) {
        input.style.display = "flex";
    } else {
        input.style.display = "none";
    }
})