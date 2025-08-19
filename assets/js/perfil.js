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
let direcciones;
let darkMode = localStorage.getItem("darkMode") || "light";
formularioDireccion = document.querySelector('#formularioDireccion');
document.addEventListener('DOMContentLoaded', async () => {
    const ResponseDataPerfil = await fetch(`index.php?controller=Perfil&action=obtenerDatosUsuario`);
    dataPerfil = await ResponseDataPerfil.json();
    seccionPerfil = localStorage.getItem('seccionPerfil') ?? 'datosPersonales';
    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    const user = await responseUser.json();
    idiomasJson = await cargarIdioma();
    const responseDireccionesUsuario = await fetch(`index.php?controller=Perfil&action=obtenerDirecciones`);
    direcciones = await responseDireccionesUsuario.json();
    //Crear tarjetas para mostrar las direcciones 
    crearTarjetasDirecciones(direcciones);

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
    darkMode = localStorage.getItem("darkMode") || "light";
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

        formGroupComunidad.innerHTML = ` <label for="comunidad" class="lang" data-lang="comunidad">${idiomasJson[lang]['direciones']['comunidad']}</label>
          <select class="theme--${darkMode}" name="comunidad" id="comunidad" required></select>`;
        const selectComunidad = document.querySelector('#comunidad');
        selectComunidad.innerHTML = `<option class="lang" data-lang="selectComunidad" value="">${idiomasJson[lang]['direciones']['selectComunidad']}</option>`;
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
                ` <label for="localidad" class="lang" data-lang="localidad">${idiomasJson[lang]['direciones']['localidad']}</label>
                  <input type="text" id="localidad" name="localidad" required >`;
        } else {
            formGroupLocalidad.innerHTML =
                ` <label for="localidad" class="lang" data-lang="localidad">${idiomasJson[lang]['direciones']['localidad']}</label>
                  <select class="theme--${darkMode}" name="localidad" id="localidad" required></select>`;
        }
        const selectLocalidad = document.querySelector('#localidad');
        selectLocalidad.innerHTML = `<option class="lang" data-lang="selectLocalidad" value="">${idiomasJson[lang]['direciones']['selectLocalidad']}</option>`;
        localidades.forEach(localidad => {
            const option = document.createElement('option');
            option.value = localidad.codigo;
            option.textContent = localidad.nombre;
            selectLocalidad.appendChild(option);
        });
    }
    if (event.target.closest('.btnBorrarDireccion')) {
        let enlaceBorrar = event.target.closest('.btnBorrarDireccion');
        fetch(`index.php?controller=Perfil&action=borrarDireccion&parametro=${enlaceBorrar.getAttribute('data-iddireccion')}`)
            .then(response => response.text())
            .then(data => {
                console.log(data);
                let mensaje = JSON.parse(data);
                console.log(mensaje);
                tooltip(idiomasJson[lang]['backMessage'][mensaje.message], mensaje.type, document.querySelector('.containerMain'));
                setInterval(() => {
                    window.location.reload();
                }, 1000)
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

function crearTarjetasDirecciones(direcciones) {
    lang = localStorage.getItem('lang');
    let containerDirecciones = document.querySelector('.direcciones');
    direcciones.forEach((direccion, i) => {
        console.log(direccion);
        let tarjetaDireccion = document.createElement('div');
        tarjetaDireccion.classList.add('tarjetaDireccion');
        tarjetaDireccion.innerHTML = `
        <h2 class="lang" data-lang="direccion">Dirección ${i + 1}</h2>
        <div class="direccion card theme--${darkMode}">
            <p class="titleDireccion lang" data-lang="pais" >${idiomasJson[lang]['direciones']['pais']}</p>
            <p class="titleDireccion lang" data-lang="comunidad" >${idiomasJson[lang]['direciones']['comunidad']}</p>
            <p class="titleDireccion lang" data-lang="localidad" >${idiomasJson[lang]['direciones']['localidad']}</p>
            <p class="titleDireccion lang" data-lang="cPostal" >${idiomasJson[lang]['direciones']['cPostal']}</p>
            <p class="titleDireccion lang" data-lang="Calle" >${idiomasJson[lang]['direciones']['Calle']}</p>
            <p class="titleDireccion lang" data-lang="Numero" >${idiomasJson[lang]['direciones']['Numero']}</p>
            <p class="titleDireccion lang" data-lang="Piso" >${idiomasJson[lang]['direciones']['Piso']}</p>
            <p class="titleDireccion lang" data-lang="Puerta" >${idiomasJson[lang]['direciones']['Puerta']}</p>
            <p class="titleDireccion lang" data-lang="deleteDireccion" >${idiomasJson[lang]['direciones']['deleteDireccion']}</p>
            <p class="pais">${direccion.paisISO}</p>
            <p class="comunidad">${direccion.provinciaMatricula}</p>
            <p class="localidad">${direccion.localidad}</p>
            <p class="cPostal">${direccion.codigo_postal}</p>
            <p class="calle">${direccion.calle}</p>
            <p class="numero">${direccion.numero}</p>
            <p class="piso">${direccion.piso}</p>
            <p class="puerta">${direccion.puerta}</p>
            <a class="btnBorrarDireccion" data-iddireccion="${direccion.id}">                           
            <svg class="iconSvg" viewBox="-3 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                <title>trash</title>
                                <desc>Created with Sketch Beta.</desc>
                                <defs>
                            </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                    <g class="contorno--fill" id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-259.000000, -203.000000)" fill="#000000">
                                        <path d="M282,211 L262,211 C261.448,211 261,210.553 261,210 C261,209.448 261.448,209 262,209 L282,209 C282.552,209 283,209.448 283,210 C283,210.553 282.552,211 282,211 L282,211 Z M281,231 C281,232.104 280.104,233 279,233 L265,233 C263.896,233 263,232.104 263,231 L263,213 L281,213 L281,231 L281,231 Z M269,206 C269,205.447 269.448,205 270,205 L274,205 C274.552,205 275,205.447 275,206 L275,207 L269,207 L269,206 L269,206 Z M283,207 L277,207 L277,205 C277,203.896 276.104,203 275,203 L269,203 C267.896,203 267,203.896 267,205 L267,207 L261,207 C259.896,207 259,207.896 259,209 L259,211 C259,212.104 259.896,213 261,213 L261,231 C261,233.209 262.791,235 265,235 L279,235 C281.209,235 283,233.209 283,231 L283,213 C284.104,213 285,212.104 285,211 L285,209 C285,207.896 284.104,207 283,207 L283,207 Z M272,231 C272.552,231 273,230.553 273,230 L273,218 C273,217.448 272.552,217 272,217 C271.448,217 271,217.448 271,218 L271,230 C271,230.553 271.448,231 272,231 L272,231 Z M267,231 C267.552,231 268,230.553 268,230 L268,218 C268,217.448 267.552,217 267,217 C266.448,217 266,217.448 266,218 L266,230 C266,230.553 266.448,231 267,231 L267,231 Z M277,231 C277.552,231 278,230.553 278,230 L278,218 C278,217.448 277.552,217 277,217 C276.448,217 276,217.448 276,218 L276,230 C276,230.553 276.448,231 277,231 L277,231 Z" id="trash" sketch:type="MSShapeGroup">
                            </path>
                                    </g>
                                </g>
                            </svg></a>
        </div>`;
        containerDirecciones.appendChild(tarjetaDireccion);
    });


}