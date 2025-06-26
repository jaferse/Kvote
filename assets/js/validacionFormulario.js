
import {aplicarValidaciones, cargarIdioma} from './funcionesGenericas.js';

/**
 * Actualiza el circulo de progreso y el texto adyacente en la pantalla
 * de registro.
 *
 * @param {number} value - El valor actual del progreso.
 * @param {number} total - El valor total del progreso.
 * @return {void}
 */
function updateProgress(value, total) {
    const circle = document.querySelector('.circle-progress');
    const text = document.querySelector('.progress-text');
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    // Calcula el desplazamiento del círculo
    const offset = circumference - (value / total) * circumference;

    // Update the progress circle and the text
    circle.style.strokeDashoffset = offset;
    text.textContent = `${value}/${total}`;
}
const cuadroDialogo = document.createElement('dialog');
const registro = document.querySelector('.registro');
const justValidate = new JustValidate('.registro__formulario');
const formulario = document.querySelector('.registro__formulario');
document.addEventListener('DOMContentLoaded', async () => {
    const dataLand = await cargarIdioma();
    let lang = localStorage.getItem("lang");
    // console.log(formulario);
    console.log(lang);

    console.log(dataLand[lang]['formulario']['validateSingIn']['username']['required']);

    let contador = 0;
    //Inicializo información de progreso
    updateProgress(0, (formulario.elements.length - 1));

    for (const element of formulario.elements) {

        if (element.type !== 'submit') {
            // console.log(element);

            element.addEventListener("blur", () => {

                justValidate.revalidateField(`#${element.id}`);
                if (element.id === "apellido2" && element.value === "") {
                    //hacemos una pausa para que pueda aceder al elemento creado
                    setTimeout(() => {
                        //Ocultamos mensaje
                        element.nextElementSibling.style.visibility = "hidden";
                    }, 1)
                    // console.log(element.previousElementSibling);

                }

                if (element.id == 'caducidad') {
                    //Si solo tiene 4 digitos agregamos "/" y revalidamos el campo
                    if (element.value.length == 4) {
                        element.value = element.value.slice(0, 2) + "/" + element.value.slice(2, 4);
                        justValidate.revalidateField(`#${element.id}`);
                    }
                    //Si tiene mas de 5 digitos lo cortamos
                    if (element.value.length >= 6) {
                        element.value = element.value.substring(0, 5);
                    }
                    //Si tiene 5 digitos le ponemos "/"
                    if (element.value.length == 5) {
                        console.log("entro 5");

                        element.value = element.value.slice(0, 2) + "/" + element.value.slice(3);
                    }

                    justValidate.revalidateField(`#${element.id}`);
                }

                const claseVerificacion = document.querySelectorAll('.just-validate-success-field');
                // console.log(claseVerificacion.length);

                updateProgress(claseVerificacion.length, (formulario.elements.length - 1))
                // console.log(contador);

            });
            element.addEventListener("input", (e) => {
                justValidate.revalidateField(`#${element.id}`);
                if (element.id == 'tarjeta') {
                    //Si tiene mas de 16 digitos lo cortamos
                    if (element.value.length >= 19) {
                        element.value = element.value.substring(0, 19);
                    }
                }
            });

        }
    }
    aplicarValidaciones(justValidate,dataLand, lang);

    // .onSuccess((e) => { //En caso de que sea correcto cada uno de los campos envia el formulario
    //     // formulario.submit();
    //     // window.location.reload()
    //     // formulario.reset();
    //     e.preventDefault();
    //     // formulario.submit();
    // })
    ;
});

formulario.addEventListener('submit', (e) => {

    e.preventDefault();
    console.log(e.target);


    justValidate.revalidate().then((isValid) => {
        if (isValid) {
            // console.log("Formulario enviado correctamente.");
            // // e.submit();
            // formulario.submit();
            const inputs = e.target.querySelectorAll('input');
            const opcion = document.querySelector('#generoFavorito');
            cuadroDialogo.classList.add('confirmacion');
            let contenidoHTML =
                `<div class="confirmacion__contenedor">
            <h2>Confirmas tus datos</h2>
            <ul>`;

            inputs.forEach(element => {

                if (element.type !== 'submit') {

                    contenidoHTML += `<li>${element.previousElementSibling.textContent}: ${element.value}</li>`;
                }

            });
            contenidoHTML += ` <li>Genero Favorito: ${opcion.value}</li>
            </ul>
            <button class="dialog__confirmar">Confirmar</button>
                <button class="dialog__volver">Volver atras</button>
                </div>`;
            cuadroDialogo.innerHTML = contenidoHTML;
            registro.appendChild(cuadroDialogo);

            cuadroDialogo.style.display = "block";



        } else {
            console.log("Formulario no válido, corrige los errores.");
        }
    });

    const mensajesVerificacion = document.querySelectorAll('.just-validate-success-label');
    const claseVerificacion = document.querySelectorAll('.just-validate-success-field');

    //Borramos todos los textos de verificación
    mensajesVerificacion.forEach(mensaje => {
        mensaje.remove();
    });

    //Borramos todas las clases de verificacion de los texto
    claseVerificacion.forEach(clase => {
        clase.classList.remove('just-validate-success-field');

    });
});

cuadroDialogo.addEventListener('click', (e) => {
    if (e.target.closest(".dialog__confirmar")) {

        formulario.action = "index.php?controller=SingIn&action=registrar";
        console.log(formulario);
        formulario.submit();

    }
    if (e.target.closest(".dialog__volver")) {
        cuadroDialogo.style.display = "none";
        cuadroDialogo.innerHTML = "";
    }
});
