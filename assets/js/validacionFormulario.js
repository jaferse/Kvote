
import { aplicarValidaciones, cargarIdioma, crearDialogo, ocultarSkeleton } from './funcionesGenericas.js';

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
    ocultarSkeleton('block');

});

formulario.addEventListener('submit', (e) => {

    e.preventDefault();
    console.log(e.target);


    justValidate.revalidate().then((isValid) => {
        if (isValid) {
            const inputs = e.target.querySelectorAll('input');
            const opcion = document.querySelector('#generoFavorito');

            let contenidoHTML = "";
            inputs.forEach(element => {
                if (element.getAttribute('type') !== 'submit') {

                    if (element.getAttribute('id') !== 'password2') {
                        if (element.getAttribute('id') == 'password') {
                            contenidoHTML += `
                            <li class="password oculta">
                                ${element.previousElementSibling.textContent}:
                                <span class="oculta">${'*'.repeat(element.value.length)}</span>
                                <span class="real" style="display: none;">${element.value}</span>
                                <a class="mostrarPassword" style="width: 2rem;">
                                    <svg class="iconSvg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M24.151 22.393c2.386-2.207 3.88-5.364 3.88-8.87 0-6.672-5.409-12.081-12.081-12.081s-12.081 5.409-12.081 12.081c0 3.507 1.495 6.664 3.881 8.871l-0.212 0.014c-1.64 2.829-0.321 5.096 1.55 7.268-0.445-1.827-0.737-3.695 0.445-5.916 0.231 0.145 0.466 0.282 0.707 0.412-0.715 2.631 0.1 4.823 1.695 6.683-0.256-1.69-0.329-3.572 0.501-5.77 0.206 0.063 0.414 0.119 0.624 0.171 0.111 2.251 0.821 4.35 1.753 6.391-0.083-1.985 0.059-3.998 0.569-6.056 0.188 0.009 0.377 0.014 0.567 0.014 0.192 0 0.384-0.005 0.574-0.014 0.511 2.058 0.653 4.071 0.569 6.056 0.932-2.042 1.643-4.141 1.753-6.393 0.21-0.052 0.418-0.109 0.623-0.171 0.831 2.198 0.758 4.081 0.502 5.772 1.596-1.86 2.411-4.053 1.694-6.686 0.24-0.129 0.476-0.267 0.706-0.412 1.185 2.223 0.892 4.091 0.447 5.919 1.871-2.172 3.189-4.439 1.55-7.268l-0.219-0.014zM8.422 15.574c0-4.159 3.371-7.53 7.53-7.53s7.53 3.371 7.53 7.53-3.372 7.53-7.53 7.53-7.53-3.371-7.53-7.53z"></path>
                                        <!-- Ojo cerrado (línea curva en lugar de pupila) -->
                                        <path class="eye-closed contorno--stroke" d="M12 15.5 Q16 17 20 15.5" stroke="#000" stroke-width="1.5" fill="none" stroke-linecap="round" />
                                        
                                        <!-- Ojo abierto (línea curva en lugar de pupila) -->
                                        <path style="display: none;" class="eye-open" d="M17.509 13.796c-1.258 0-2.278-1.020-2.278-2.278 0-0.353 0.081-0.688 0.224-0.986-2.116 0.394-3.717 2.249-3.717 4.479 0 2.517 2.040 4.557 4.557 4.557s4.557-2.040 4.557-4.557c-0-1.145-0.422-2.191-1.12-2.991-0.229 1.017-1.136 1.777-2.222 1.777zM16.065 17.749c-0.818 0-1.481-0.663-1.481-1.481s0.663-1.481 1.481-1.481c0.818 0 1.481 0.663 1.481 1.481s-0.663 1.481-1.481 1.481z"></path>
                                    </svg>
                                </a>
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
        let ojos = e.target.closest('.toggle-password>.iconSvg');
        let passwordInput = e.target.closest('.registro__formulario__group').querySelector('#password') || e.target.closest('.registro__formulario__group').querySelector('#password2');
        passwordInput.setAttribute('type', passwordInput.getAttribute('type') === 'password' ? 'text' : 'password'); // Cambia el atributo type = 'text';
        let eyeClosed = ojos.querySelector('.eye-closed');
        let eyeOpen = ojos.querySelector('.eye-open');
        eyeClosed.style.display = eyeClosed.style.display == 'none' ? 'inline' : 'none';
        eyeOpen.style.display = eyeOpen.style.display == 'none' ? 'inline' : 'none';
    }
})
