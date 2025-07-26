import { cargarIdioma } from './funcionesGenericas.js';
const justValidate = new JustValidate('.registro__formulario');
const formulario = document.querySelector('.registro__formulario');
// console.log(formulario);

document.addEventListener('DOMContentLoaded', async () => {

    const dataLand = await cargarIdioma();
    let lang = localStorage.getItem("lang");
    // console.log(lang);

    // console.log(dataLand[lang]['formulario']['validateSingIn']['username']['required']);
    //Recogemos todos los elementos del formulario
    for (const element of formulario.elements) {
        //Si no es un botón de tipo submit, le añadimos el evento blur y input
        if (element.type !== 'submit') {
            // console.log(element);
            //Le añadimos el evento blur y input para que sea interactivo
            element.addEventListener("blur", () => {
                justValidate.revalidateField(`#${element.id}`);
            });
            element.addEventListener("input", (e) => {
                justValidate.revalidateField(`#${element.id}`);
            });
        }
    }


    justValidate.addField('#userName',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['username']['required']
            },
            {
                rule: 'minLength',
                value: 3,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['username']['minLength']
            },
            {
                rule: 'maxLength',
                value: 30,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['username']['maxLength']
            },
            {
                rule: 'customRegexp',
                value: /^[A-Za-z0-9!"#$%&'()*+,\-./:;<=>?@\[\]\\^_`{|}~]+$/,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['username']['custom']
            },

        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['username']['successMessage'],

        }

    ).addField('#password',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['password']['required']

            },
            {
                rule: 'minLength',
                value: 2,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['password']['minLength']
            },
            {
                rule: 'maxLength',
                value: 50,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['password']['maxLength']
            },
            {
                rule: 'customRegexp',
                value: /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[._+]).{6,}$/,

                errorMessage: dataLand[lang]['formulario']['validateSingIn']['password']['custom']
            },
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['password']['successMessage'],
        }
    )
});

formulario.addEventListener('submit', async (e) => {

    e.preventDefault();

    justValidate.revalidate().then((isValid) => {
        if (isValid) {
            formulario.action = "index.php?controller=LogIn&action=logear";
            formulario.submit();

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

document.addEventListener('click', function (event) {
    if (event.target.closest('.toggle-password')) {
        let passwordInput = event.target.closest('.registro__formulario__group').querySelector('#password');
        passwordInput.setAttribute('type', passwordInput.getAttribute('type') === 'password' ? 'text' : 'password'); // Cambia el atributo type = 'text' o 'pastword'

        let eyeClosed=document.querySelector('.eye-closed');
        let eyeOpen=document.querySelector('.eye-open');

        eyeClosed.style.display=eyeClosed.style.display=='none'?'inline':'none';
        eyeOpen.style.display=eyeOpen.style.display=='none'?'inline':'none';
        
    }
})