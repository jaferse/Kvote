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
// console.log(formulario);

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


justValidate.addField('#userName',
    [
        {
            rule: 'required',
            errorMessage: 'El nombre debe ser rellenado'
        },
        {
            rule: 'minLength',
            value: 3,
            errorMessage: 'Al menos debe de contener 3 caracteres'
        },
        {
            rule: 'maxLength',
            value: 30,
            errorMessage: 'No puede superar los 30 caracteres'
        },
        {
            rule: 'customRegexp',
            value: /^[A-Za-z0-9!"#$%&'()*+,\-./:;<=>?@\[\]\\^_`{|}~]+$/,
            errorMessage: 'El nombre de usuario solo puede tener carácteres con mayúsculas, minúsculas, dígitos y estos carácteres especiales: ! " # $ % & \' ( ) * + , - . / : ; < = > ? @ [ \ ] ^ _ { | } ~'
        },

    ],
    {
        successMessage: 'Nombre usuario valido',

    }

).addField('#nombre',
    [
        {
            rule: 'required',
            errorMessage: 'El nombre debe ser rellenado'

        },
        {
            rule: 'minLength',
            value: 2,
            errorMessage: 'Al menos debe de contener 3 caracteres'
        },
        {
            rule: 'maxLength',
            value: 30,
            errorMessage: 'No puede superar los 30 caracteres'
        },
        {
            rule: 'customRegexp',
            value: /^[\p{L}\s]+$/u,

            errorMessage: 'El nombre solo puede tener carácteres con mayúsculas, minúsculas y espacios'
        },
    ],
    {
        successMessage: 'Nombre valido',
    }
).addField('#apellido1',
    [
        {
            rule: 'required',
            errorMessage: 'El primer apellido debe ser rellenado'

        },
        {
            rule: 'minLength',
            value: 2,
            errorMessage: 'Al menos debe de contener 3 caracteres'
        },
        {
            rule: 'maxLength',
            value: 30,
            errorMessage: 'No puede superar los 30 caracteres'
        },
        {
            rule: 'customRegexp',
            value: /^[\p{L}\s]+$/u,

            errorMessage: 'El Apellido solo puede tener carácteres con mayúsculas, minúsculas y espacios'
        },
    ],
    {
        successMessage: 'Primer apellido valido',
    }
).addField('#apellido2',
    [
        {
            rule: 'minLength',
            value: 2,
            errorMessage: 'Al menos debe de contener 3 caracteres'
        },
        {
            rule: 'maxLength',
            value: 30,
            errorMessage: 'No puede superar los 30 caracteres'
        },
        {
            rule: 'customRegexp',
            value: /^[\p{L}\s]+$/u,

            errorMessage: 'El Apellido solo puede tener carácteres con mayúsculas, minúsculas y espacios'
        }
    ],
    {
        successMessage: "Segundo apellido válido",
    }

).addField('#email',
    [
        {
            rule: 'required',
            errorMessage: 'El correo debe ser rellenado'

        },
        {
            rule: 'maxLength',
            value: 320,
            errorMessage: 'No puede superar los 320 caracteres'
        },
        {
            rule: 'customRegexp',
            value: /^[A-Za-z0-9_.+]{2,}@[A-Za-z0-9]{2,}\.[a-z]{2,5}$/,

            errorMessage: 'El correo debe de tener formato: nombre@dominio.com'
        },
    ],
    {
        successMessage: 'Correo valido',
    }

).addField('#password',
    [
        {
            rule: 'required',
            errorMessage: 'La contraseña debe ser rellenada'

        },
        {
            rule: 'minLength',
            value: 2,
            errorMessage: 'Al menos debe de contener 6 caracteres'
        },
        {
            rule: 'maxLength',
            value: 50,
            errorMessage: 'No puede superar los 50 caracteres'
        },
        {
            rule: 'customRegexp',
            value: /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[._+]).{6,}$/,

            errorMessage: 'La contraseña debe de tener una longitud minima de 6 caracteres e incluir al menos una mayuscula, minuscula numero y caracter especial . _ +',
        },
    ],
    {
        successMessage: 'Contraseña valida',
    }
).addField('#password2',
    [
        {
            rule: "required",
            errorMessage: "Debes confirmar la contraseña",
        },
        {
            validator: (value, fields) => {
                return value === fields['#password'].elem.value;
            },
            errorMessage: "Las contraseñas no coinciden",
        }

    ],
    {

        successMessage: 'Contraseña valida',
    }

).addField('#birth',
    [
        {
            rule: 'required',
            errorMessage: 'La fecha de nacimiento debe ser rellenada',
        },
        {
            validator: (value) => {
                let introducida = new Date(value);
                let fechaLimite = new Date();
                fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
                // console.log(introducida + " - " + fechaLimite);
                return (introducida) <= fechaLimite;
            },
            errorMessage: "Debes ser mayor de edad para poder registrarte",
        }
    ],
    {
        successMessage: 'Fecha correcta',
    }



).addField('#tarjeta',

    [
        {
            rule: 'required',
            errorMessage: 'Número de tarjeta obligatoria',
        },
        {
            rule: 'maxLength',
            value: 19,
            errorMessage: 'Debe tener 16 caracteres',
        },
        {
            rule: 'customRegexp',
            value: /^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/,
            errorMessage: 'Formato de tarjeta incorrecto',
        }
    ],
    {
        successMessage: 'Número tarjeta valido',
    }


).addField('#caducidad',

    [
        {
            rule: 'required',
            errorMessage: 'Caducidad obligatoria',
        },
        {
            rule: 'maxLength',
            value: 5,
            errorMessage: 'Debe tener formato MM/AA',
        },
        {
            rule: 'minLength',
            value: 5,
            errorMessage: 'Debe tener formato MM/AA'
        },
        {
            rule: 'customRegexp',
            value: /^(0[1-9]|1[0-2])\/([0-9]{2})$/,
            errorMessage: 'Debe tener formato MM/AA',
        },
        {
            validator: (value) => {
                let hoy = new Date();
                valido = false;
                // console.log(value.substring(0,2)," == ", (hoy.getMonth().toString()),(parseInt(value.substring(0,2)) >= parseInt(hoy.getMonth())+1));
                //Si el año es mayor la fecha es correcta
                if (value.substring(3) > ((hoy.getFullYear().toString()).substring(2))) {
                    // console.log("Año correcto");

                    valido = true;

                }
                //Si el año es igual y el mes es mayor o igual 
                else if ((value.substring(3) == ((hoy.getFullYear().toString()).substring(2))) && (parseInt(value.substring(0, 2)) >= parseInt(hoy.getMonth()) + 1)) {
                    console.log("mes correcto");
                    valido = true;

                } else {
                    console.log("Año Incorrecto");

                }
                return valido;
            },
            errorMessage: "Tarjeta caducada",
        }
    ],
    {
        successMessage: 'Caducidad correcta',
    }


).addField('#CVV',
    [
        {
            rule: 'required',
            errorMessage: 'CVV obligatoria',
        },
        {
            rule: 'maxLength',
            value: 3,
            errorMessage: 'Debe tener 3 caracteres',
        },
        {
            rule: 'minLength',
            value: 3,
            errorMessage: 'Debe tener 3 caracteres'
        },
        {
            rule: 'number',
            errorMessage: 'Debe ser un numero',
        }
    ],
    {
        successMessage: 'CVV correcto',
    }


).addField('#generoFavorito',
    [
        {
            rule: 'required',
            errorMessage: 'Elige un genero favorito',
        }
    ]

).addField('#tipo_tarjeta',
    [
        {
            rule: 'required',
            errorMessage: 'Elige el tipo de tarjeta',
        }
    ]
)
    // .onSuccess((e) => { //En caso de que sea correcto cada uno de los campos envia el formulario
    //     // formulario.submit();
    //     // window.location.reload()
    //     // formulario.reset();
    //     e.preventDefault();
    //     // formulario.submit();
    // })
    ;


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

                // console.log(element.value);
                // console.log(element.previousElementSibling.textContent);
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
