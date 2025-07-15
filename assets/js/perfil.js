import { cargarIdioma, crearDialogo, tooltip } from "./funcionesGenericas.js";
import { darseBajaTraduccir } from "./lang.js";

const justValidate = new JustValidate('#formularioPass');
let lang = 'es';
let idiomasJson;
const formularioPass = document.querySelector('#formularioPass');
let seccionPerfil;
document.addEventListener('DOMContentLoaded', async () => {
    seccionPerfil = localStorage.getItem('seccionPerfil') ?? 'datosPersonales';
    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    const user = await responseUser.json();
    idiomasJson = await cargarIdioma();
    lang = localStorage.getItem('lang', user.idioma);
    let mensaje = JSON.parse(localStorage.getItem('flash_msg', user.idioma));
    darseBajaTraduccir(idiomasJson, lang);

    let classContainer = `.container${seccionPerfil.charAt(0).toUpperCase() + seccionPerfil.slice(1)}`;
    document.querySelector(classContainer).style.display = 'flex';

    if (mensaje) {
        tooltip(idiomasJson[lang]['cambiarPassword'][mensaje.message], mensaje.type, document.querySelector('.containerPassWord'));
        localStorage.removeItem('flash_msg');
    }
    document.querySelector('.usuario').textContent = user.username;

    document.addEventListener('click', async (event) => {
        let id = event.target.getAttribute('id');

        //Si se ha hecho click en un enlace del menú lateral
        if (id === 'baja' || id === 'tarjetaCredito' || id === 'direcciones' || id === 'passWord' || id === 'datosPersonales') {
            //Ocultar el resto de los contenedores
            ocultarContenedores();
            //Guardar la sección en el localStorage
            localStorage.setItem('seccionPerfil', id);
            //Mostrar el contenedor de baja
            classContainer = `.container${id.charAt(0).toUpperCase() + id.slice(1)}`;
            document.querySelector(classContainer).style.display = 'flex';
        }

        //Si se ha hecho click en el botón de formalizar baja
        if (event.target.closest('.btnBaja')) {
            //Redirigir a la página de baja
            try {
                const responseBaja = await fetch(`index.php?controller=Perfil&action=baja&username=${user.username}`);
                const baja = await responseBaja.text();
                crearDialogo(
                    {
                        title: 'Baja formalizada',
                        message: 'Baja formalizada correctamente',
                        mensajeAceptar: 'Aceptar',
                        mensajeCancelar: 'Registrarme',
                    },
                    () => {
                        window.location.href = `index.php?controller=Index&action=view`;
                    },
                    () => {
                        window.location.href = `index.php?controller=SingIn&action=view`;
                    }
                )
                window.location.href = `index.php?controller=Index&action=view`;
            } catch (error) {
                console.error(error);
            }
        }

    });

    //Recorremos los elementos del formularios para añadir eventos input y blur
    for (const element of formularioPass.elements) {
        if (element.type !== 'button') {
            element.addEventListener('blur', () => {
                justValidate.revalidateField(`#${element.id}`)
            });

            element.addEventListener("input", (e) => {
                justValidate.revalidateField(`#${element.id}`);
            });
        }
    }

    validacionReglas(justValidate, idiomasJson, lang);
});

function ocultarContenedores() {
    document.querySelectorAll('.container').forEach(container => {
        container.style.display = 'none';
    });
}

function validacionReglas(justValidate, idiomasJson, lang) {
    justValidate.addField('#passWordOld',
        [
            {
                rule: 'required',
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['required']

            }, {
                rule: 'minLength',
                value: 2,
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['minLength']
            },
            {
                rule: 'maxLength',
                value: 50,
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['maxLength']
            },
            {
                rule: 'customRegexp',
                value: /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[._+]).{6,}$/,

                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['custom']
            },

        ],
        {
            successMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['successMessage'],
        }
    ).addField('#passWordNew',
        [
            {
                rule: 'required',
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['required']

            }, {
                rule: 'minLength',
                value: 2,
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['minLength']
            },
            {
                rule: 'maxLength',
                value: 50,
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['maxLength']
            },
            {
                rule: 'customRegexp',
                value: /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[._+]).{6,}$/,

                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['custom']
            },

        ],
        {
            successMessage: idiomasJson[lang]['formulario']['validateSingIn']['password']['successMessage'],
        }
    ).addField('#passWordNew2',

        [
            {
                rule: "required",
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password2']['required'],
            },
            {
                validator: (value, fields) => {
                    return value === fields['#passWordNew'].elem.value;
                },
                errorMessage: idiomasJson[lang]['formulario']['validateSingIn']['password2']['errorMessage'],
            }

        ],
        {

            successMessage: idiomasJson[lang]['formulario']['validateSingIn']['password2']['successMessage'],
        }

    );
}
const btnCambiarPass = document.querySelector('.btnCambiarPass');
btnCambiarPass.addEventListener('click', (e) => {
    e.preventDefault();

    justValidate.revalidate().then((isValid) => {
        if (isValid) {
            formularioPass.submit();
        } else {
            console.log("Formulario no válido.");
        }
    }).catch((error) => {
        console.error("Error al validar el formulario:", error);
    });
});