import { cargarIdioma, crearDialogo, tooltip, ocultarSkeleton } from "./funcionesGenericas.js";
import { darseBajaTraduccir } from "./lang.js";

const justValidate = new JustValidate('#formularioPass');
let lang = 'es';
let idiomasJson;
const formularioPass = document.querySelector('#formularioPass');
let seccionPerfil;
let dataPerfil
let classContainer;
let comunidades;
let localidades;
let codPais = '';
let codComunidad = '';
let formularioDireccion;
formularioDireccion = document.querySelector('#formularioDireccion');
document.addEventListener('DOMContentLoaded', async () => {
    const ResponseDataPerfil = await fetch(`index.php?controller=Perfil&action=obtenerDatosUsuario`);
    dataPerfil = await ResponseDataPerfil.json();
    seccionPerfil = localStorage.getItem('seccionPerfil') ?? 'datosPersonales';
    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    const user = await responseUser.json();
    idiomasJson = await cargarIdioma();
    lang = localStorage.getItem('lang', user.idioma);
    let mensaje = JSON.parse(localStorage.getItem('flash_msg', user.idioma));
    darseBajaTraduccir(idiomasJson, lang);

    cambiarValorInputFormActualizarDatos();

    classContainer = `.container${seccionPerfil.charAt(0).toUpperCase() + seccionPerfil.slice(1)}`;
    document.querySelector(classContainer).style.display = 'flex';
    if (mensaje) {
        tooltip(idiomasJson[lang]['backMessage'][mensaje.message], mensaje.type, document.querySelector('.containerMain'));
        localStorage.removeItem('flash_msg');
    }
    document.querySelector('.usuario').textContent = user.username;

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

    ocultarSkeleton('flex');
});

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
    if (event.target.id == 'pais' && event.target.value == '') {
        codPais = '';
        codComunidad = '';
        ((document.querySelector('.formGroup.comunidad')) ? document.querySelector('.formGroup.comunidad').innerHTML = "" : '');
        ((document.querySelector('.formGroup.localidad')) ? document.querySelector('.formGroup.localidad').innerHTML = "" : '');
    }
    if (event.target.id == 'comunidad' && event.target.value == '') {
        codComunidad = '';
        ((document.querySelector('.formGroup.localidad')) ? document.querySelector('.formGroup.localidad').innerHTML = "" : '');
    }
    if (event.target.id == 'pais' && event.target.value != '' && event.target.value != codPais) {
        codPais = event.target.value;
        ((document.querySelector('.formGroup.comunidad')) ? document.querySelector('.formGroup.comunidad').innerHTML = "" : '');
        ((document.querySelector('.formGroup.localidad')) ? document.querySelector('.formGroup.localidad').innerHTML = "" : '');
        const responseComunidades = await fetch(`index.php?controller=Perfil&action=obtenerComunidades&parametro=${codPais}`);
        comunidades = await responseComunidades.json();
        const formGroupComunidad = document.querySelector('.formGroup.comunidad');

        formGroupComunidad.innerHTML = ` <label for="comunidad" class="lang" data-lang="comunidad">Comunidad:</label>
          <select name="comunidad" id="comunidad" required></select>`;
        const selectComunidad = document.querySelector('#comunidad');
        selectComunidad.innerHTML = '<option value="">Seleccione una comunidad</option>';
        comunidades.forEach(comunidad => {
            const option = document.createElement('option');
            option.value = comunidad.codigo_matricula;
            option.textContent = comunidad.nombre;
            selectComunidad.appendChild(option);
        });
    }
    if (event.target.id == 'comunidad' && event.target.value != '' && event.target.value != codComunidad) {
        codComunidad = event.target.value;
        ((document.querySelector('.formGroup.localidad')) ? document.querySelector('.formGroup.localidad').innerHTML = "" : '');
        const responseLocalidades = await fetch(`index.php?controller=Perfil&action=obtenerLocalidades&parametro=${codPais}-${codComunidad}`);
        localidades = await responseLocalidades.json();
        // console.log(localidades);

        const formGroupLocalidad = document.querySelector('.formGroup.localidad');
        // console.log(formGroupLocalidad);
        if (localidades.length == 0) {
            formGroupLocalidad.innerHTML =
                ` <label for="localidad" class="lang" data-lang="localidad">Localidad:</label>
                  <input type="text" id="localidad" name="localidad" required >`;
        } else {
            formGroupLocalidad.innerHTML =
                ` <label for="localidad" class="lang" data-lang="localidad">Localidad:</label>
                  <select name="localidad" id="localidad" required></select>`;
        }
        const selectLocalidad = document.querySelector('#localidad');
        selectLocalidad.innerHTML = '<option value="">Seleccione una localidad</option>';
        localidades.forEach(localidad => {
            const option = document.createElement('option');
            option.value = localidad.codigo;
            option.textContent = localidad.nombre;
            selectLocalidad.appendChild(option);
        });
    }

});

formularioDireccion.addEventListener('submit', async (event) => {
    event.preventDefault();

    let datos = new FormData(formularioDireccion);
    if (
        validarFormularioDireccion(datos)
    ) {
        formularioDireccion.submit();
    }
})

function validarFormularioDireccion(datos) {

    //Verificamos que no hay dato vacios
    if (datos.get('pais') == '' ||
        datos.get('comunidad') == '' ||
        datos.get('localidad') == '' ||
        datos.get('codPostal') == '' ||
        datos.get('calle') == '' ||
        datos.get('numero') == ''
    ) {
        tooltip(idiomasJson[lang]['frontMessage']['1011'], 'error', document.querySelector('.containerMain'));
        return false;
    }
    //Verificamos que el codigo de país se corresponde con el codigo postal correcto
    if (
        (datos.get('pais') == 'PT' && datos.get('codPostal').length != 7) ||
        (datos.get('pais') == 'ES' && datos.get('codPostal').length != 5) ||
        (datos.get('pais') == 'FR' && datos.get('codPostal').length != 5)
    ) {
        tooltip(idiomasJson[lang]['frontMessage']['1012'], 'error', document.querySelector('.containerMain'));
        console.log('El codigo postal no es correcto');
        return false;
    }
    return true;

}
function cambiarValorInputFormActualizarDatos() {
    document.querySelector('#formularioDataUser #nombre').value = dataPerfil.nombre;
    document.querySelector('#formularioDataUser #Apellido1').value = dataPerfil.apellido1;
    document.querySelector('#formularioDataUser #Apellido2').value = dataPerfil.apellido2;
}
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

const btnCambiarData = document.querySelector('.btnCambiarData');
btnCambiarData.addEventListener('click', (e) => {
    e.preventDefault();
    const formularioDataUser = document.querySelector('#formularioDataUser');
    let datos = new FormData(formularioDataUser);
    if (
        datos.get('nombre').length > 2 &&
        datos.get('Apellido1').length > 2 &&
        datos.get('Apellido2').length > 2 &&
        datos.get('nombre').length < 50 &&
        datos.get('Apellido1').length < 45 &&
        datos.get('Apellido2').length < 45
    ) {
        formularioDataUser.submit();
    } else {
        tooltip(idiomasJson[lang]['frontMessage']['1010'], 'error', document.querySelector('.containerMain'));
    }

});