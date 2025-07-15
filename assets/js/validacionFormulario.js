
import { aplicarValidaciones, cargarIdioma, crearDialogo } from './funcionesGenericas.js';

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
// const cuadroDialogo = document.createElement('dialog');
const registro = document.querySelector('.registro');
const justValidate = new JustValidate('.registro__formulario');
const formulario = document.querySelector('.registro__formulario');
document.addEventListener('DOMContentLoaded', async () => {
    const dataLand = await cargarIdioma();
    let lang = localStorage.getItem("lang");

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
    aplicarValidaciones(justValidate, dataLand, lang);

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

            let contenidoHTML = "";
            inputs.forEach(element => {
                if (element.getAttribute('type') !== 'submit') {

                    console.log(element);
                    console.log(element.previousElementSibling.textContent);
                    console.log(element.value);
                    if (element.getAttribute('id') !== 'password2') {
                        if (element.getAttribute('id') == 'password') {
                            contenidoHTML += `
                            <li class="password oculta">
                                ${element.previousElementSibling.textContent}:
                                <span class="oculta">${'*'.repeat(element.value.length)}</span>
                                <span class="real" style="display: none;">${element.value}</span>
                                <a class="mostrarPassword"><img class="eye" src="assets/img/eye.png" alt="Mostrar contraseña"></a>
                                </li>`;

                        } else {
                            contenidoHTML += `<li>${element.previousElementSibling.textContent}: ${element.value}</li>`;
                        }
                    }
                    console.log(contenidoHTML);

                }
            });
            crearDialogo({ titulo: "Confirma los datos", mensaje: contenidoHTML, mensajeAceptar: "Registrarse", mensajeCancelar: "Atrás" },
                () => {

                    formulario.action = "index.php?controller=SingIn&action=registrar";
                    console.log(formulario);
                    formulario.submit();

                },
                () => {
                }
            )



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


document.addEventListener('click', (e) => {

    if (e.target.parentElement.classList.contains('mostrarPassword')) {
        console.log(e.target.parentElement);

        const passwordItem = e.target.closest('.password'); // el <li>

        if (passwordItem.classList.contains('oculta')) {
            passwordItem.querySelector('.oculta').style.display = 'none';
            passwordItem.querySelector('.real').style.display = 'inline';
        } else {
            passwordItem.querySelector('.oculta').style.display = 'inline';
            passwordItem.querySelector('.real').style.display = 'none';
        }
        passwordItem.classList.toggle('oculta');

    }

    if (e.target.closest('.toggle-password')) {
        let passwordInput = e.target.closest('.registro__formulario__group').querySelector('#password') || e.target.closest('.registro__formulario__group').querySelector('#password2');
        let spanEye = e.target.closest('.registro__formulario__group').querySelector('.eye');
        passwordInput.setAttribute('type', passwordInput.getAttribute('type') === 'password' ? 'text' : 'password'); // Cambia el atributo type = 'text';
        spanEye.setAttribute('src', spanEye.getAttribute('src') === './assets/img/eyeOpen.png' ? './assets/img/eye.png' : './assets/img/eyeOpen.png'); // Cambia el ojo 
    }
})
