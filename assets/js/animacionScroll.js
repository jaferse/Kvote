//Acedemos a las dimensiones de las secciones de nosotros
const nosotros__historia = document.querySelector('.nosotros__historia');
// const rectHistoria = nosotros__historia.getBoundingClientRect();

const nosotros__mision = document.querySelector('.nosotros__mision');
// const rectMision = nosotros__mision.getBoundingClientRect();

const nosotros__editorial = document.querySelector('.nosotros__editorial');
// const rectEditorial = nosotros__editorial.getBoundingClientRect();

const nosotros__talleres = document.querySelector('.nosotros__talleres');
// const rectTalleres = nosotros__talleres.getBoundingClientRect();

/**
 * Visualiza la seccion que se le pasa como parametro, solo si su borde superior
 * esta a una distancia de retardoPx por debajo del borde inferior del viewport.
 * Si no se cumple esta condicion, la seccion se oculta.
 * @param {HTMLElement} seccion - La seccion que se quiere visualizar
 * @param {number} retardoPx - La distancia en pixels que debe haber entre el borde
 *                             superior de la seccion y el borde inferior del
 *                             viewport para que se visualice la seccion.
 * @param {boolean} direcion true es por la derecha y false por la izquierda
*/
function visualizarSeccion(seccion, retardoPx, direcion) {
    const rect = seccion.getBoundingClientRect();
    // let viewportInferior = window.scrollY + window.innerHeight;

    if (((rect.top - window.innerHeight) + retardoPx) < 0) {
        if (direcion) {
            seccion.classList.add('nosotros--desplazamientoLeft');
        }else{
            seccion.classList.add('nosotros--desplazamientoRight');

        }
        
    }
}


window.addEventListener('scroll', (e) => {

    visualizarSeccion(nosotros__historia, 100, true);
    visualizarSeccion(nosotros__mision, 100, false);
    visualizarSeccion(nosotros__editorial, 100, true);
    visualizarSeccion(nosotros__talleres, 100, false);

})