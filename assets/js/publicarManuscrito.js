
const tablaPrecios = {
    primero: {
        titulo: "Diseño de la portada",
        autodisenio: {
            opc: "Ya tengo portada",
            precio: 0
        },
        portadista: {
            opc: "Contratar diseño",
            precio: 300
        }
    },
    segundo: {
        titulo: "Creación de Prólogo",
        propio: {
            opc: "Escribir el prólogo personalmente",
            precio: 0
        },
        Encargar: {
            opc: "Encargar el prólogo a un escritor/editor",
            precio: 200
        },
        Celebre: {
            opc: "Prólogo por un invitado especial o autor reconocido",
            precio: 500
        }
    },
    tercero: {
        titulo: "Tipo de Papel",
        Blanco: {
            opc: "Blanco estándar",
            precio: 200
        },
        Ahuesado: {
            opc: "Ahuesado o crema",
            precio: 300
        },
        Brillante: {
            opc: "Brillante o satinado",
            precio: 400
        },
        Especial: {
            opc: "Reciclado",
            precio: 500
        },
        Reciclado: {
            opc: "Especial (texturizado, pergamino, algodón)",
            precio: 150
        },
    },
    cuarto: {
        titulo: "Tipo de Cubierta",
        Blanda: {
            opc: "Tapa blanda",
            precio: 100
        },
        Dura: {
            opc: "Tapa dura",
            precio: 300
        },
        Sobrecubierta: {
            opc: "Cubierta con sobrecubierta",
            precio: 350
        },
        Digital: {
            opc: "Edición digital",
            precio: 50
        },
        Combinado: {
            opc: "Paquete combinado",
            precio: 400
        },
    },
    quinto: {
        titulo: "Acabado de la cubierta",
        Mate: {
            opc: "Mate",
            precio: 100
        },
        Brillante: {
            opc: "Brillante",
            precio: 150
        },
        "Soft-touch": {
            opc: "Soft-touch",
            precio: 250
        },
        Relieve: {
            opc: "Impresión en relieve",
            precio: 400
        },
    },
    sexto: {
        titulo: "Diseño de Contraportada",
        personalizado: {
            opc: "Escribir un texto personalizado",
            precio: 100
        },
        FotoAutor: {
            opc: "Incluir foto del autor",
            precio: 150
        },
        Comentarios: {
            opc: "Añadir comentarios o reseñas",
            precio: 250
        },
    },
    septimo: {
        titulo: "Número de Ejemplares",
        BajoDemanda: {
            opc: "Impresión bajo demanda",
            precio: 100
        },
        TiradaCorta: {
            opc: "Tiradas cortas",
            precio: 200
        },
        TiradaGrande: {
            opc: "Tiradas grandes",
            precio: 1000
        },
    },
    octavo: {
        titulo: "Tamaño del Libro",
        A5: {
            opc: "A5 (14,8 x 21 cm)",
            precio: 100
        },
        B6: {
            opc: "B6 (12,5 x 19 cm)",
            precio: 150
        },
        A4: {
            opc: "A4 (21 x 29,7 cm)",
            precio: 200
        },
        Cuadrado: {
            opc: "Cuadrado (21 x 21 cm)",
            precio: 400
        },
        Personalizado: {
            opc: "Formato personalizado",
            precio: 800
        },
    },
    noveno: {
        titulo: "Encuadernación",
        Cosida: {
            opc: "Cosida",
            precio: 500
        },
        Fresada: {
            opc: "Fresada",
            precio: 350
        },
        Espiral: {
            opc: "Wire-O o espiral",
            precio: 100
        },
    },
}
console.log(tablaPrecios['primero']);

let opciones = document.querySelectorAll('.opcion');
let selecciones = [];
const secciones = document.querySelectorAll('.seccion');
opciones.forEach((opcion, i) => {
    opcion.addEventListener('click', (e) => {
        console.log("[DEBUG] Seleccionado" + e.target);

        //Si es la primera selección
        if (opcion.classList.contains('containerEditorial__primero__opc')) {
            selecionar("primero", ".containerEditorial__primero__opc", selecciones, opcion);
        }

        //Si es la segunda selección
        if (opcion.classList.contains('containerEditorial__segundo__opc')) {
            selecionar("segundo", ".containerEditorial__segundo__opc", selecciones, opcion);
        }
        //Si es la tercera selección
        if (opcion.classList.contains('containerEditorial__tercero__opc')) {
            selecionar("tercero", ".containerEditorial__tercero__opc", selecciones, opcion);
        }
        //Si es la cuarto selección
        if (opcion.classList.contains('containerEditorial__cuarto__opc')) {
            selecionar("cuarto", ".containerEditorial__cuarto__opc", selecciones, opcion);
        }
        //Si es la quinto selección
        if (opcion.classList.contains('containerEditorial__quinto__opc')) {
            selecionar("quinto", ".containerEditorial__quinto__opc", selecciones, opcion);
        }
        //Si es la sexto selección
        if (opcion.classList.contains('containerEditorial__sexto__opc')) {
            selecionar("sexto", ".containerEditorial__sexto__opc", selecciones, opcion);
        }
        //Si es la sexto selección
        if (opcion.classList.contains('containerEditorial__septimo__opc')) {
            selecionar("septimo", ".containerEditorial__septimo__opc", selecciones, opcion);
        }
        //Si es la octavo selección
        if (opcion.classList.contains('containerEditorial__octavo__opc')) {
            selecionar("octavo", ".containerEditorial__octavo__opc", selecciones, opcion);
        }
        //Si es la noveno selección
        if (opcion.classList.contains('containerEditorial__noveno__opc')) {
            selecionar("noveno", ".containerEditorial__noveno__opc", selecciones, opcion);
        }

    });
});
document.addEventListener('click', (e) => {
    //Si es un botón entra
    if (e.target.tagName == "BUTTON") {
        //Acedemos a la sección padre
        const seccionPadre = e.target.closest('.seccion');

        //Si la encontramos
        if (seccionPadre) {
            console.log(seccionPadre);
            //Sacamos el indice de la sección en la que nos encontramos
            const indiceBoton = Array.from(secciones).indexOf(seccionPadre);
            //Si es siguiente avanzamos
            if (e.target.classList.contains('siguiente')) {
                //Comprobamos si se a seleccionado algo
                if (seleccionado(seccionPadre)) {
                    mostrarSiguiente(secciones, indiceBoton);
                } else {
                    alert("Debes seleccionar una opción para continuar");
                }
            }
            //Si es atras retrocedemos
            else if (e.target.classList.contains('atras')) {
                mostrarAnterior(secciones, indiceBoton);
            }
        } else {
            console.error('No se encontró la sección padre del botón');
        }

    }
});

function mostrarSiguiente(secciones, indice) {
    console.log(indice);

    secciones[indice].style.display = "none";
    secciones[indice + 1].style.display = "flex";
    if (indice == 8) {
        console.log("Resumen");

        rellenarResumen(selecciones);
    }

}
function mostrarAnterior(secciones, indice) {
    secciones[indice].style.display = "none";
    secciones[indice - 1].style.display = "flex";

}

function seleccionado(seccionPadre) {
    let seleccionado = false;
    seccionPadre.querySelectorAll('.opcion').forEach(opcion => {
        if (opcion.classList.contains('active')) {
            seleccionado = true;
        }
    })
    return seleccionado;
}

function eliminarOpciones(opcienesSeccion) {
    opcienesSeccion.forEach(opcion => {
        opcion.classList.remove('active');
    })
}


function selecionar(indiceArray, claseSeccion, selecciones, opcion) {

    //Condición para controlar que no están ambas marcadas con estilo active
    if ((opcion.getAttribute('data-valor') !== selecciones[indiceArray]) && selecciones[indiceArray] !== "") {
        console.log("[DEBUG] La está eliminando");
        let seccion = document.querySelectorAll(claseSeccion);
        eliminarOpciones(seccion);
        opcion.classList.toggle('active');
    } else {
        opcion.classList.toggle('active');
    }
    //Si se desmarca borramos el contenido del array
    if (!opcion.classList.contains('active')) {
        console.log("[DEBUG] La está desmarcando");
        selecciones[indiceArray] = "";
    } else {
        selecciones[indiceArray] = opcion.getAttribute('data-valor');
    }
    console.log("[DEBUG]" + selecciones[indiceArray]);
}

function rellenarResumen(selecciones) {
    let resumen = document.querySelector('.resumen');
    let precioTotal = 0;
    resumen.querySelectorAll('tr').forEach((parrafo, i) => {
        console.log(parrafo, " ", parrafo.id);
        console.log(selecciones[parrafo.id]);
        if (i > 0) {

            if (parrafo.id !== "precioTotal") {
                precioTotal += tablaPrecios[`${parrafo.id}`][`${selecciones[parrafo.id]}`]['precio'];
                parrafo.innerHTML = "<td>" + tablaPrecios[`${parrafo.id}`]["titulo"] + "</td>";
                parrafo.innerHTML += "<td>" + tablaPrecios[`${parrafo.id}`][`${selecciones[parrafo.id]}`]['opc'] + "</td>";
                parrafo.innerHTML += "<td>" + tablaPrecios[`${parrafo.id}`][`${selecciones[parrafo.id]}`]['precio'] + " €</td>";
            } else {
                document.querySelector('#precioTotal').innerHTML = "<td colspan='3'>" + precioTotal + " €</td>";
            }
        }
    });

    console.log(precioTotal);

}

document.querySelector('.tramitar').addEventListener('click', () => {
    location.reload();
});
