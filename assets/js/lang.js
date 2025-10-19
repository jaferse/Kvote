import { convertirFormatoFecha, cargarIdioma } from './funcionesGenericas.js';
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const json = await cargarIdioma();

        //Si no hay local storage le asignamos español por defecto
        if (!localStorage.getItem("lang")) {
            localStorage.setItem("lang", "es");
        }
        //Si hay local storage le asignamos el idioma que haya
        let lang = localStorage.getItem("lang");
        actualizarTexto(json, lang);

        // Agregar eventos de traducción a los botones
        document.querySelectorAll(".translate").forEach(button => {
            let lang;
            button.addEventListener("click", function (e) {
                //Alguna clase padre tiene la clase es
                if (e.target.closest(".es")) {

                    lang = "es"; // Obtener el idioma del botón
                    this.classList.add("es");
                    this.classList.remove("en", "ja");
                }
                if (e.target.closest(".en")) {
                    lang = "en"; // Obtener el idioma del botón
                    this.classList.add("en");
                    this.classList.remove("es", "ja");

                }
                if (e.target.closest(".ja")) {
                    lang = "ja"; // Obtener el idioma del botón
                    this.classList.add("ja");
                    this.classList.remove("es", "es");

                }
                localStorage.setItem("lang", lang);
                lang = localStorage.getItem("lang");
                actualizarTexto(json, lang);
            });
        });

    } catch (error) {
        console.log(error);
    }
});

// Función para actualizar los textos
function actualizarTexto(json, lang) {

    //Cambio de titulo
    document.title = json[lang]["title"];

    /**
     * Nav
     */
    document.querySelectorAll('.nav__menu .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');
        element.textContent = json[lang]["nav"][data_lang];
    });

    /**
     * Menu Login
     */
    document.querySelectorAll('.menuLogin .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');
        element.textContent = json[lang]["menuLogin"][data_lang];

    })

    /**
     * Características del producto
     */

    document.querySelectorAll('.Producto__info__caracteristicas>ul>li').forEach(element => {
        element.classList.remove("es", "en", "ja");
        element.classList.add(lang);

    });

    /**
     * Cambiar idoma historial de pedidos
     */
    if (document.querySelector('.containerPedidos')) {
        let contenedor = document.querySelectorAll('.containerPedidos  .lang');
        contenedor.forEach(element => {
            if (element.classList.contains('fecha')) {
                element.innerHTML = convertirFormatoFecha(element.getAttribute("data-fecha"), true);
            } else {
                let data_lang = element.getAttribute('data-lang');
                element.textContent = json[lang]["historialPedidos"][data_lang];
            }
        })
    }

    /**
     * Cambiar idioma de whislist
     */

    if (document.querySelector('.containerProductosWishList')) {
        let nombre = document.querySelector('.containerProductosWishList span');
        document.querySelector('.containerProductosWishList .lang').textContent = json[lang]["wishList"]["titulo"];
        document.querySelector('.containerProductosWishList .lang').appendChild(nombre);

        document.querySelectorAll('.productosWishList .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["wishList"][data_lang];
        });

    }

    /**
     * Cambiar idioma de carrito
     */
    if (document.querySelector('.containerCesta')) {
        document.querySelectorAll('.containerCesta .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["carrito"][data_lang];
        });
    }
    if (document.querySelector('.cestaVacia img')) {
        if (document.querySelector('.cestaVacia img').closest('.productosWishList')) {

            document.querySelector('.cestaVacia img').src = `assets/img/libroWishListVacia${lang}.png`;
        }
        if (document.querySelector('.cestaVacia img').closest('.containerCesta')) {
            document.querySelector('.cestaVacia img').src = `assets/img/libroCestaVacia${lang}.png`;
        }
    }


    /**
     * Botones producto
     */
    if (document.querySelector('.botonCesta')) {
        document.querySelector('.botonCesta').textContent = json[lang]["producto"]["annadirCesta"];
    }
    if (document.querySelector('.botonWishlist')) {
        document.querySelector('.botonWishlist').textContent = json[lang]["producto"]["annadirWishlist"];
    }

    /**
     * Cambiar idioma comentarios
     */

    if (document.querySelector('.Producto__comentarios')) {
        document.querySelectorAll('.Producto__comentarios .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["comentarios"][data_lang];
            if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
                element.setAttribute("placeholder", json[lang]["comentarios"][data_lang]);
            }
        });
    }

    /**
     * Cambiar idioma de categoria productos
     */
    if (document.querySelector('.Producto__info__caracteristicas')) {
        document.querySelectorAll('.Producto__info__caracteristicas>p').forEach(element => {

            setTimeout(() => {
                if (element.classList.contains("Producto__info__caracteristicas__publicacion>p")) {
                    element.textContent = convertirFormatoFecha(element.getAttribute("data-fecha"));

                } else {
                    let data_lang = element.getAttribute('data-lang');
                    let data_content = element.getAttribute('data-content');
                    element.textContent = json[lang]["producto"][data_lang][data_content];
                }
            }, 500);
        });

    }

    /**
     * Cambiar idioma precio anterior
     * 
     */
    if (document.querySelector('.Producto__info__precioComprar__precio__anterior')) {
        document.querySelector('.Producto__info__precioComprar__precio__anterior').classList.remove("es", "en", "ja");
    }
    if (document.querySelector('.Producto__info__precioComprar__precio__anterior')) {
        document.querySelector('.Producto__info__precioComprar__precio__anterior').classList.add(lang);
    }


    /**
     * Cambiar idioma tarjeta productos
     */

    document.querySelectorAll('.containerProductos__producto>.containerProductos__producto__info').forEach(element => {
        let botonVermas = element.querySelector('.verMas')

        botonVermas.textContent = (botonVermas.classList.contains('active')) ? json[lang]["producto"]["ocultar"] : json[lang]["producto"]["verMas"];
        element.querySelector('.containerProductos__producto__info__adicional__Formato').classList.remove('es', 'en', 'ja');
        element.querySelector('.containerProductos__producto__info__adicional__Tipo').classList.remove('es', 'en', 'ja');
        element.querySelector('.containerProductos__producto__info__adicional__Paginas').classList.remove('es', 'en', 'ja');
        element.querySelector('.containerProductos__producto__info__adicional__Formato').classList.add(lang);
        element.querySelector('.containerProductos__producto__info__adicional__Tipo').classList.add(lang);
        element.querySelector('.containerProductos__producto__info__adicional__Paginas').classList.add(lang);
    });

    /**
     * Cambiar idioma sinopsis
     */
    document.querySelectorAll('.Producto__info__sinopsis').forEach(element => {
        element.classList.remove("es", "en", "ja");
        element.classList.add(lang);

    });

    /**
     * Placeholder de buscador
     */
    document.querySelector('#buscar').setAttribute("placeholder", json[lang]["buscador"]);

    /**
     * main (tops productos)
     */
    document.querySelectorAll('.main__bestSellers .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');
        //Obtenemos el mes actual
        let mes = new Date().getMonth();
        element.textContent = json[lang]["main__bestSellers"][data_lang] + json[lang]["main__bestSellers"]["months"][mes];
    });

    /*
    *Sección nosotros
    */
    //Titulo
    if (document.querySelector('.welcome .lang')) {
        document.querySelector('.welcome .lang').textContent = json[lang]["nosotros"]["title"];
    }

    //Nosotros Hisotria
    document.querySelectorAll('.nosotros__historia__text .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');
        element.textContent = json[lang]["nosotros"]["nosotros__historia"][data_lang];
    });

    //Nosotros Mision

    document.querySelectorAll('.nosotros__mision__text .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');

        //si hay subsecciones entramos en ellas
        if (element.getAttribute("data-lang").substring(0, 3) == "sub") {
            element.textContent = json[lang]["nosotros"]["nosotros__mision"]["parrafo2"][data_lang];
        } else {
            element.textContent = json[lang]["nosotros"]["nosotros__mision"][data_lang];
        }

    });

    //Nosotros Editorial
    document.querySelectorAll('.nosotros__editorial__text .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');

        //si hay subsecciones entramos en ellas
        if (element.getAttribute("data-lang").substring(0, 3) == "sub") {
            element.textContent = json[lang]["nosotros"]["nosotros__editorial"]["parrafo3"][data_lang];
        } else {
            element.textContent = json[lang]["nosotros"]["nosotros__editorial"][data_lang];
        }

    });


    //Nosotros Talleres
    document.querySelectorAll('.nosotros__talleres__text .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');

        //si hay subsecciones entramos en ellas
        if (element.getAttribute("data-lang").substring(0, 3) == "sub") {
            element.textContent = json[lang]["nosotros"]["nosotros__talleres"]["parrafo2"][data_lang];
        } else {
            element.textContent = json[lang]["nosotros"]["nosotros__talleres"][data_lang];
        }

    });

    //colaboradores
    document.querySelectorAll('.nosotros__talleres__colaboradores .lang').forEach(element => {
        let data_lang = element.getAttribute('data-lang');

        //si hay subsecciones entramos en ellas

        element.textContent = json[lang]["nosotros"]["colaboradores"][data_lang];


    });

    /**
     * Formulario
     */

    if (document.querySelector('.registro__contenedor .registro__title') && document.querySelector('.SingIn')) {
        document.querySelector('.registro__contenedor .registro__title').textContent = json[lang]["formulario"]["title"];
        document.querySelectorAll('.registro__formulario .lang').forEach(elemento => {
            let data_lang = elemento.getAttribute('data-lang');
            //Si es un select
            if (elemento.querySelector('select')) {
                elemento.querySelector('label').textContent = json[lang]["formulario"][elemento.getAttribute('data-lang')]["title"];
                elemento.querySelector('select').querySelectorAll('option').forEach(option => {
                    data_lang = option.getAttribute('data-lang')
                    option.textContent = json[lang]["formulario"][elemento.getAttribute('data-lang')][data_lang];
                });

            }
            //Si es un enlacee
            else if (elemento.tagName === 'A') {
                elemento.textContent = json[lang]["formulario"][data_lang];

            }
            //Si es el botón
            else if (elemento.querySelector('input').getAttribute('type') == "submit") {
                elemento.querySelector('input').value = json[lang]["formulario"][data_lang];
            }
            //Para el resto de input
            else {
                elemento.querySelector('label').textContent = json[lang]["formulario"][data_lang];
                elemento.querySelector('input').setAttribute("placeholder", json[lang]["formulario"][data_lang]);
            }
        });
    } else if (document.querySelector('.registro__contenedor .registro__title') && document.querySelector('.singIn')) {
        document.querySelector('.registro__contenedor .registro__title').textContent = json[lang]["formularioLogIn"]["title"];

        document.querySelectorAll('.registro__formulario .lang').forEach(elemento => {
            let data_lang = elemento.getAttribute('data-lang');

            //Si es el botón
            if (elemento.tagName === 'A') {
                elemento.textContent = json[lang]["formularioLogIn"][data_lang];
            } else if (elemento.querySelector('input').getAttribute('type') == "submit") {
                elemento.querySelector('input').value = json[lang]["formularioLogIn"][data_lang];
            }
            //Para el resto de input
            else {
                elemento.querySelector('label').textContent = json[lang]["formularioLogIn"][data_lang];
                elemento.querySelector('input').setAttribute("placeholder", json[lang]["formularioLogIn"][data_lang]);
            }
        });
    }

    /**
     * cambiar idioma de los errores del formulario 
     */

    if (document.querySelector('.just-validate-success-label') || document.querySelector('.just-validate-error-label')) {
        location.reload(); //Recargamos la página para que se apliquen los cambios de idioma en los errores del formulario
    }


    /**
     * Footer
     */
    document.querySelectorAll('.footer .lang').forEach(element => {

        let data_lang = element.getAttribute('data-lang');

        switch (element.parentElement.classList.value) {
            case "footer__ayuda":
                element.textContent = json[lang]["Footer"]["ayuda"][data_lang]
                break;
            case "footer__nosotros__contacto":
                element.textContent = json[lang]["Footer"]["Contacto"]["title"]
                break;
            case "footer__redes__contenedor":
                element.textContent = json[lang]["Footer"]["Redes Sociales"]["title"]
                break;
            default:
                element.textContent = "";
                break;
        }
    });

    if (document.querySelector('.subnavegador')) {
        document.querySelectorAll('.subnavegador .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["subnavegador"][data_lang];
        })
    }

    if (document.querySelector('.mainAdmin.artista')) {
        document.querySelectorAll('.mainAdmin.artista th.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["mainAdmin"]["artista"][data_lang];
        })
        document.querySelectorAll('.mainAdmin.artista option.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["paises"][data_lang];
        });
    }

    //Botones de los CRUD
    if (document.querySelector('.mainAdmin .btn.lang')) {
        document.querySelectorAll('.mainAdmin .btn.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.value = json[lang]["mainAdmin"]["botones"][data_lang];
        })
    }
    //Botón de subir del CRUD de producto
    if (document.querySelector('.mainAdmin.producto .fileInputLabel')) {
        document.querySelectorAll('.mainAdmin.producto .fileInputLabel').forEach(element => {
            element.textContent = json[lang]["mainAdmin"]["botones"]["subir"];
        });
    }

    //Trabajos en CRUD productos
    if (document.querySelector('.mainAdmin.producto .trabajo')) {
        document.querySelectorAll('.mainAdmin.producto .trabajo .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]['mainAdmin']['producto']['trabajos'][data_lang];
        })
    }

    //opciones de crud de productos
    if (document.querySelector('.mainAdmin.producto option')) {
        document.querySelector('.mainAdmin.producto .autor>option').textContent = json[lang]['mainAdmin']['producto']['selectArtista'];

        document.querySelectorAll('.mainAdmin.producto .tipo>option').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]['producto']['Tipo'][data_lang];
        });
        document.querySelectorAll('.mainAdmin.producto .formato>option').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]['producto']['Formato'][data_lang];
        });
        document.querySelectorAll('.mainAdmin.producto .subtipo>option').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]['producto']['Subtipo'][data_lang];
        });
        document.querySelectorAll('.mainAdmin.producto table>thead>tr>th').forEach(element => {
            let data_lang = element.getAttribute('data-lang');

            element.textContent = json[lang]['mainAdmin']['producto']['th'][data_lang];
        });
    }

    //Cambiar idioma de formulario de datos de usuario
    if (document.querySelector('#formularioDataUser label.lang')) {
        document.querySelector('.containerDatosPersonales .title').textContent = json[lang]["menuLateralPerfil"]["datosPersonales"];
        document.querySelectorAll('#formularioDataUser label.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["formulario"][data_lang];
        });
        document.querySelector('#formularioDataUser input[type="button"]').value = json[lang]["mainAdmin"]["botones"]["actualizar"];
    }

    if (document.querySelector('.containerDirecciones #formularioDireccion .lang')) {
        document.querySelectorAll('#formularioDireccion #pais .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["paises"][data_lang];
        });
        document.querySelectorAll('#formularioDireccion label.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["direciones"][data_lang];
        })
        document.querySelector('.containerDirecciones .title').textContent = json[lang]["direciones"]["title"];
        document.querySelector('.containerDirecciones .newDireccion').textContent = json[lang]["direciones"]["newDireccion"];
        document.querySelectorAll('#localidad option.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["direciones"][data_lang];
        })
        document.querySelectorAll('#comunidad option.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["direciones"][data_lang];
        })
    }

    if (document.querySelector('.direcciones .tarjetaDireccion .lang')) {
        document.querySelector('.lang.titleDireccion').textContent = json[lang]["direciones"]["title"];
        document.querySelectorAll('.direcciones .tarjetaDireccion h2.lang').forEach((element, i) => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["direciones"]['title'] + ` ${i + 1}`;

        })
        document.querySelectorAll('.direcciones .tarjetaDireccion .lang:not(h2)').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["direciones"][data_lang];
        })
    }

    if (document.querySelector('.tarjetaDireccion .lang')) {
        document.querySelectorAll('.tarjetaDireccion title.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["direciones"][data_lang];
        });
    }

    if (document.querySelector('.formulario #formularioTarjeta')) {
        document.querySelectorAll('.containerTarjetaCredito .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["formularioTarjetaNew"][data_lang];
        })
        document.querySelectorAll('.formulario #formularioTarjeta .lang:not([type="submit"])').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["formularioTarjetaNew"][data_lang];
        });
        document.querySelector('.formulario #formularioTarjeta input[type="submit"]').value = json[lang]["mainAdmin"]["botones"]["nuevo"];
        document.querySelectorAll('.formulario #formularioTarjeta #tipo_tarjeta option:not(:first-of-type).lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["formulario"]['tipo_tarjeta'][data_lang];
        })
    }

    if (document.querySelector('.tarjetaCredito .lang')) {

        document.querySelectorAll('.tarjetaCredito h2.lang.subtitulo').forEach((element, i) => {
            element.textContent = json[lang]['formularioTarjetaNew']['subtitulo'] + ' ' + (i + 1);
        })

        document.querySelectorAll('.tarjetaCredito .columna p.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["formularioTarjetaNew"][data_lang];
        })
    }
    if (document.querySelector('.siguiente .lang')) {
        document.querySelectorAll('.siguiente .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["mainAdmin"]['botones'][data_lang];
        })
    }
    if (document.querySelector('.anterior .lang')) {
        document.querySelectorAll('.anterior .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["mainAdmin"]['botones'][data_lang];
        })
    }
    if (document.querySelector('.finalizarCompra .lang')) {
        document.querySelectorAll('.finalizarCompra .lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            element.textContent = json[lang]["mainAdmin"]['botones'][data_lang];
        })
    }

    if (document.querySelector('.sinPedidos .lang')) {
        document.querySelector('.sinPedidos .lang').textContent = json[lang]['historialPedidos']['sinPedidos']
    }

    if (document.querySelector('.main__sliderFrame')) {
        document.querySelectorAll('.main__sliderFrame img').forEach((element, i) => {
            let partes=element.src.split('.');
            element.src=partes[0].slice(0,-3)+`_${lang}.`+partes[1];
            
        });
    }

    if (document.querySelector('.buscadorSinProductos')) {        
        document.querySelector('.buscadorSinProductos > .lang').textContent = json[lang]['search']['sinProductos']
        document.querySelector('.buscadorSinProductos > img').src=`assets/img/libroCestaVacia${lang}.png`;
    }

    //Cambiar idioma de darse de baja
    darseBajaTraduccir(json, lang);

    //Cambiar idioma de menu lateral de perfil
    menuLateralPerfilTraduccir(json, lang);

    //Cambiar idioma de cambiar contraseña
    cambiarPasswordTraduccir(json, lang);
}

export function cambiarPasswordTraduccir(json, lang) {

    if (document.querySelector('.containerPassWord')) {
        let container = document.querySelector('.containerPassWord');
        container.querySelectorAll('.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');

            if (element.getAttribute('type') == 'button') {
                element.value = json[lang]["cambiarPassword"][data_lang];
            }
            else {

                if (data_lang) {
                    element.textContent = json[lang]["cambiarPassword"][data_lang];
                }
            }
        });
    }
}

export function darseBajaTraduccir(json, lang) {
    if (document.querySelector('.containerBaja')) {
        let container = document.querySelector('.containerBaja');
        container.querySelectorAll('.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            if (data_lang) {
                element.textContent = json[lang]["darseBaja"][data_lang];
            }
        });
    }
}

export function menuLateralPerfilTraduccir(json, lang) {
    if (document.querySelector('.menuLateral')) {
        const menuLateral = document.querySelector('.menuLateral');
        menuLateral.querySelectorAll('.lang').forEach(element => {
            let data_lang = element.getAttribute('data-lang');
            if (data_lang) {
                element.textContent = json[lang]["menuLateralPerfil"][data_lang];
            }
        });

    }
}