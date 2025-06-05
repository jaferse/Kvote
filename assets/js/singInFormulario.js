const justValidate = new JustValidate('.registro__formulario');
const formulario = document.querySelector('.registro__formulario');
console.log(formulario);

//Recogemos todos los elementos del formulario
for (const element of formulario.elements) {
    //Si no es un botón de tipo submit, le añadimos el evento blur y input
    if (element.type !== 'submit') {
        console.log(element);
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
)

formulario.addEventListener('submit', (e) => {

    e.preventDefault();
    console.log(e.target);


    justValidate.revalidate().then((isValid) => {
        if (isValid) {
            // console.log("Formulario enviado correctamente.");
            // // e.submit();

            formulario.action = "index.php?controller=LogIn&action=logear";
            formulario.submit();
            console.log("Formulario enviado correctamente.");
            




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