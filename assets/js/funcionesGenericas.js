export function convertirFormatoFecha(fecha, hora = false) {
    let lang = localStorage.getItem("lang") || "es";
    const fechaDate = new Date(fecha);
    switch (lang) {
        case "es":
            const fechaEs = fechaDate.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });
            const horaEs = hora
                ? fechaDate.toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit'
                })
                : "";
            fecha = !hora ? `${fechaEs}` : `${fechaEs}<br>${horaEs}`;
            break;
        case "en":
            const fechaEn = fechaDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });
            const horaEn = hora
                ? fechaDate.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                }) : '';
            fecha = !hora ? `${fechaEn}` : `${fechaEn}<br>${horaEn}`;
            break;
        case "ja":
            const diasJapon = ['日', '月', '火', '水', '木', '金', '土']; //Dias de la semana en japonés
            const diaSemana = diasJapon[fechaDate.getDay()];
            const dia = fechaDate.getDate();
            const mes = fechaDate.getMonth() + 1;
            const anio = fechaDate.getFullYear();
            const horaTexto = hora
                ? ` ${String(fechaDate.getHours()).padStart(2, '0')}:${String(fechaDate.getMinutes()).padStart(2, '0')}`
                : '';
            fecha = !hora ? `${anio}年${mes}月${dia}日 (${diaSemana})` : `${anio}年${mes}月${dia}日 (${diaSemana})<br>${horaTexto}`;
            break;
    }
    return fecha;
}

export function aplicarValidaciones(justValidate, dataLand, lang) {

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

    ).addField('#nombre',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['nombre']['required']

            },
            {
                rule: 'minLength',
                value: 2,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['nombre']['minLength']
            },
            {
                rule: 'maxLength',
                value: 30,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['nombre']['maxLength']
            },
            {
                rule: 'customRegexp',
                value: /^[\p{L}\s]+$/u,

                errorMessage: dataLand[lang]['formulario']['validateSingIn']['nombre']['custom']
            },
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['nombre']['successMessage'],
        }
    ).addField('#apellido1',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['apellido1']['required'],

            },
            {
                rule: 'minLength',
                value: 2,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['apellido1']['minLength'],
            },
            {
                rule: 'maxLength',
                value: 30,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['apellido1']['maxLength'],
            },
            {
                rule: 'customRegexp',
                value: /^[\p{L}\s]+$/u,

                errorMessage: dataLand[lang]['formulario']['validateSingIn']['apellido1']['custom'],
            },
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['apellido1']['successMessage'],
        }
    ).addField('#apellido2',
        [
            {
                rule: 'minLength',
                value: 2,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['apellido2']['minLength'],
            },
            {
                rule: 'maxLength',
                value: 30,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['apellido2']['maxLength'],
            },
            {
                rule: 'customRegexp',
                value: /^[\p{L}\s]+$/u,

                errorMessage: dataLand[lang]['formulario']['validateSingIn']['apellido2']['custom'],
            }
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['apellido2']['successMessage'],
        }

    ).addField('#email',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['email']['required'],

            },
            {
                rule: 'maxLength',
                value: 320,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['email']['maxLength'],
            },
            {
                rule: 'customRegexp',
                value: /^[A-Za-z0-9_.+]{2,}@[A-Za-z0-9]{2,}\.[a-z]{2,5}$/,

                errorMessage: dataLand[lang]['formulario']['validateSingIn']['email']['custom'],
            },
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['email']['successMessage'],
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
    ).addField('#password2',
        [
            {
                rule: "required",
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['password2']['required'],
            },
            {
                validator: (value, fields) => {
                    return value === fields['#password'].elem.value;
                },
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['password2']['errorMessage'],
            }

        ],
        {

            successMessage: dataLand[lang]['formulario']['validateSingIn']['password2']['successMessage'],
        }

    ).addField('#birth',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['birth']['required'],
            },
            {
                validator: (value) => {
                    let introducida = new Date(value);
                    let fechaLimite = new Date();
                    fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
                    // console.log(introducida + " - " + fechaLimite);
                    return (introducida) <= fechaLimite;
                },
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['birth']['menor'],
            }
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['birth']['successMessage'],
        }



    ).addField('#tarjeta',

        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['tarjeta']['required'],
            },
            {
                rule: 'maxLength',
                value: 19,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['tarjeta']['maxLength'],
            },
            {
                rule: 'customRegexp',
                value: /^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['tarjeta']['custom'],
            }
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['tarjeta']['successMessage'],
        }


    ).addField('#caducidad',

        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['caducidad']['caducidad'],
            },
            {
                rule: 'maxLength',
                value: 5,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['caducidad']['custom'],
            },
            {
                rule: 'minLength',
                value: 5,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['caducidad']['custom'],
            },
            {
                rule: 'customRegexp',
                value: /^(0[1-9]|1[0-2])\/([0-9]{2})$/,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['caducidad']['custom'],
            },
            {
                validator: (value) => {
                    let hoy = new Date();
                    let valido = false;
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
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['caducidad']['caducada'],
            }
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['caducidad']['successMessage'],
        }


    ).addField('#CVV',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['cvv']['required'],
            },
            {
                rule: 'maxLength',
                value: 3,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['cvv']['maxLength'],
            },
            {
                rule: 'minLength',
                value: 3,
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['cvv']['minLength'],
            },
            {
                rule: 'number',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['cvv']['number'],
            }
        ],
        {
            successMessage: dataLand[lang]['formulario']['validateSingIn']['cvv']['successMessage'],
        }


    ).addField('#generoFavorito',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['generoFavorito'],
            }
        ]

    ).addField('#tipo_tarjeta',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['tipoTarjeta'],
            }
        ]
    ).addField('#emisor_tarjeta',
        [
            {
                rule: 'required',
                errorMessage: dataLand[lang]['formulario']['validateSingIn']['emisorTarjeta'],
            }
        ]
    )
}

/**
 * Devuelve el ISBN13 de un producto desde la URL actual
 * @returns {string} El ISBN13 del producto
 * @throws {Error} Si no se encuentra el par metro en la URL
 */
export function getISBN13() {
    let URL = new URLSearchParams(window.location.search);
    let isbn = URL.get("isbn");
    if (isbn) {
        return isbn;
    } else {
        console.error("Error: No se ha encontrado el ISBN en la URL.");
    }

}

export async function cargarIdioma() {
    const responseLang = await fetch('assets/lang/es.json');
    const dataLang = await responseLang.json();
    return dataLang;
}


/**
 * Crea un diálogo modal con el título y mensaje proporcionados,
 * y llama a las funciones onAceptar y onCancelar cuando se
 * pulsa el botón de aceptar o cancelar, respectivamente.
 * @param {Object} datos - Un objeto con los siguientes
 *   campos: titulo, mensaje, mensajeAceptar, mensajeCancelar
 * @param {function} onAceptar - Función a llamar cuando se
 *   pulsa el botón de aceptar
 * @param {function} onCancelar - Función a llamar cuando se
 *   pulsa el botón de cancelar
 */
export function crearDialogo(datos, onAceptar, onCancelar) {
    // Si ya existe, no lo volvemos a crear
    if (document.getElementById("dialogoPersonalizado")) return;
    console.log(datos);

    let titulo = datos.titulo;
    let mensaje = datos.mensaje;
    // Crear overlay
    const overlay = document.createElement("div");
    overlay.id = "overlay";
    console.log(typeof mensaje);


    // Crear diálogo
    const dialogo = document.createElement("div");
    dialogo.id = "dialog";

    dialogo.innerHTML = `
    <h1>${titulo}</h1>
    <p>${mensaje}</p>
    <div class="botones">
    ${datos['mensajeAceptar'] ? `<button id="btnAceptar" class="btn btnPrimario">${datos['mensajeAceptar']}</button>` : ''}
    ${datos['mensajeCancelar'] ? `<button id="btnCancelar" class="btn btnTerciario">${datos['mensajeCancelar']}</button>` : ''}
    </div>
  `;

    document.body.appendChild(overlay);
    document.body.appendChild(dialogo);

    document.getElementById("btnAceptar").onclick = () => {
        cerrarDialogo();
        if (typeof onAceptar === "function") onAceptar();
    };

    document.getElementById("btnCancelar").onclick = () => {
        cerrarDialogo();
        if (typeof onCancelar === "function") onCancelar();
    };

    function cerrarDialogo() {
        overlay.remove();
        dialogo.remove();
    }
}


/**
 * Crea un tooltip con el mensaje y estilo dados, y lo agrega al
 * contenedor proporcionado. El tooltip se elimina automáticamente
 * después del tiempo especificado (por defecto 2000ms). La función
 * devuelve el elemento del tooltip.
 * @param {string} mensaje - El mensaje que se mostrará en el tooltip
 * @param {string} style - El estilo del tooltip ( "exito", "error", "warning" )
 * @param {HTMLElement} contenedor - El contenedor donde se agregará el tooltip
 * @param {number} [time=2000] - El tiempo en ms que el tooltip permanecerá visible
 * @returns {HTMLElement} El elemento del tooltip
 */
export function tooltip(mensaje, style, contenedor, time = 2000) {
    if (!mensaje) {
        mensaje = "Error inesperado";
    }
    const tooltip = document.createElement('div');
    tooltip.classList.add('tooltip', style);
    tooltip.innerHTML = mensaje;
    contenedor.appendChild(tooltip);
    setTimeout(() => {
        tooltip.remove();
    }, time);
    return tooltip;
}


export function ocultarSkeleton(display='flex') {
    
    // Ocultamos el skeleton
    const skeleton = document.querySelector('.cardSkeleton');
    skeleton.style.display = 'none';
    const main = document.querySelector('main');
    main.style.display = display;
}

export function mostrarSkeleton(display='flex') {
    
    // Ocultamos el skeleton
    const skeleton = document.querySelector('.cardSkeleton');
    skeleton.style.display = display;
    const main = document.querySelector('main');
    main.style.display = 'none';
}