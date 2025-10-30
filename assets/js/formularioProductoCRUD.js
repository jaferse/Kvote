// Este script se encarga de cambiar la acción del formulario dependiendo del botón que se presione
import { tooltip, cargarIdioma, ocultarSkeleton, mostrarSkeleton } from "./funcionesGenericas.js";
let formProducto = document.getElementById('formProducto');
let formProductoNuevo = document.getElementById('formProductoNuevo');
let page;
let seccion;
let respuestaTrabajo;
let trabajos;
let respuestaTipos;
let tipos;
let respuestaFormatos;
let formatos;
let respuestaSubtipos;
let subtipos;
let respuestaProductos
let productos;
let lang;
let jsonIdiomas;
let themeDark = localStorage.getItem('darkMode') || 'light';

document.addEventListener('DOMContentLoaded', async () => {
    if (localStorage.getItem("flash_msg")) {
        let jsonIdiomas = await cargarIdioma();
        let lang = localStorage.getItem("lang") || 'es';
        if (JSON.parse(localStorage.getItem("flash_msg")) && JSON.parse(localStorage.getItem("flash_msg")).type !== '' && JSON.parse(localStorage.getItem("flash_msg")).message !== '') {
            let mensaje = JSON.parse(localStorage.getItem("flash_msg"));
            await tooltip(jsonIdiomas[lang]['crudProducto'][mensaje.message], mensaje.type, document.querySelector('.mainAdmin'));
            localStorage.removeItem("flash_msg");
        }
    }
    if (localStorage.getItem('lang') === 'es' || localStorage.getItem('lang') === 'en' || localStorage.getItem('lang') === 'ja') {
        lang = localStorage.getItem('lang');
    }
    jsonIdiomas = await cargarIdioma();

    page = 1;
    if (localStorage.getItem('seccion') === 'productoCRUD') {
        const p = parseInt(localStorage.getItem('page'), 10);
        if (Number.isInteger(p) && p > 0) page = p;
    }
    localStorage.setItem('seccion', 'productoCRUD');
    localStorage.setItem('page', page);
    seccion = 'productoCRUD';

    //Listar trabajos
    respuestaTrabajo = await fetch(`index.php?controller=Producto&action=obtenerTrabajos`);
    trabajos = await respuestaTrabajo.json();

    //Listar tipo
    respuestaTipos = await fetch(`index.php?controller=Producto&action=listarTipos`);
    tipos = await respuestaTipos.json();

    //Listar formato
    respuestaFormatos = await fetch(`index.php?controller=Producto&action=listarFormatos`);
    formatos = await respuestaFormatos.json();

    //Listar Genero
    respuestaSubtipos = await fetch(`index.php?controller=Producto&action=listarGeneros`);
    subtipos = await respuestaSubtipos.json();

    //Listar productos
    respuestaProductos = await fetch(`index.php?controller=Producto&action=obtenerProductosPaginado&page=${page}`)
    productos = await respuestaProductos.json();

    await construirTabla();
    await construirPaginacionTablas(page, { controller: 'Producto', container: '.mainAdmin' });
    ocultarSkeleton('block');
    fileEventChange();
});

/**
 * Agrega un evento a los elementos con la clase "fileInput" para verificar si
 * el archivo seleccionado es de tipo imagen y mostrar un mensaje en caso de
 * que no lo sea.
 */
function fileEventChange() {

    document.querySelectorAll('.fileInput').forEach(input => {

        input.addEventListener('change', function () {

            const file = this.files[0];
            comprobarExtensionImagen(file, input);

        });
    });
}
function comprobarExtensionImagen(file, input) {
    if (!file) return;

    const tiposPermitidos = [
        "image/png",
        "image/jpeg",
        "image/webp",
        "image/gif",
        "image/bmp",
        "image/svg+xml",
        "image/x-icon"
    ];

    if (!tiposPermitidos.includes(file.type)) {
        tooltip(jsonIdiomas[lang]['frontMessage']['1000'], 'error', document.querySelector('.mainAdmin'), 5000);
        input.value = ""; // resetea el input
    } else {
        tooltip(jsonIdiomas[lang]['frontMessage']['2000'], 'exito', document.querySelector('.mainAdmin'), 5000);
    }

}


formProducto.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    event.target.name;
    //Sacamos el valor del botón que se ha presionado
    const botonPresionado = event.submitter.value; // Obtiene el valor del botón que disparó el evento

    // Controla la ruta en función del botón que se presiona
    switch (botonPresionado) {
        case 'Actualizar':
            formProducto.action = "index.php?controller=Producto&action=actualizar";
            break;
        case 'Eliminar':
            formProducto.action = "index.php?controller=Producto&action=eliminar";
            break;
    }
    formProducto.querySelectorAll('input[type="text"]').forEach(text => {
        text.value = text.value.trim(); // Elimina espacios en blanco al inicio y al final
    });
    formProducto.submit(); // Envía el formulario con la nueva acción
});

formProductoNuevo.addEventListener('submit', function (event) {
    event.preventDefault();
    formProductoNuevo.querySelectorAll('input[type="text"]').forEach(text => {
        text.value = text.value.trim(); // Elimina espacios en blanco al inicio y al final
    });

    if (!event.target[1].value) {
        event.target.reportValidity();
        tooltip(jsonIdiomas[lang]['frontMessage']['1009'], 'error', document.querySelector('.mainAdmin'), 5000);
    } else {
        formProductoNuevo.submit();
    }
});
document.addEventListener('click', async (e) => {
    if (e.target.closest('.translate')) {
        lang = localStorage.getItem('lang');
    }
    if (e.target.tagName === 'A') {
        mostrarSkeleton('block');
        let numeroPagina = e.target.getAttribute('data-page');
        localStorage.setItem('page', numeroPagina);
        respuestaProductos = await fetch(`index.php?controller=Producto&action=obtenerProductosPaginado&page=${numeroPagina}`);
        productos = await respuestaProductos.json();
        await construirTabla();
        await construirPaginacionTablas(numeroPagina, { controller: 'Producto', container: '.mainAdmin' });
        ocultarSkeleton('block');
    }
});

document.addEventListener('input', async (e) => {
    const tipo = e.target.type;
    let value = e.target.value;

    //Si es la isbn 13, solo permitimos números y limitamos a 13 caracteres
    if (e.target.classList.contains('isbn')) {
        let newValue;
        newValue = value.replace(/[^0-9]/g, '');
        if (newValue.length > 13) {
            tooltip(jsonIdiomas[lang]['frontMessage']['1003'], 'error', document.querySelector('.mainAdmin'), 5000);
            newValue = newValue.slice(0, 13); // Limita a 13 caracteres
        }
        e.target.value = newValue; // Asigna el valor modificado al input

        // Si la longitud es menor a 13, mostramos un mensaje de error
        if (e.target.value.length !== 13) {
            e.target.setCustomValidity(jsonIdiomas[lang]['frontMessage']['1003']);
            e.target.reportValidity();
        } else {
            e.target.setCustomValidity('');
        }
    }

    if (e.target.classList.contains('fileInput')) {

        comprobarExtensionImagen(e.target.files[0], e.target)
        //Si hay más de una archivo se borra el input y se muestra un tooltip de error
        if (e.target.files.length > 1) {
            e.target.value = "";
            tooltip(jsonIdiomas[lang]['frontMessage']['1001'], 'error', document.querySelector('.mainAdmin'), 5000);
        }

        //Si el archivo es mayor de 16MB se borra el input y se muestra un tooltip de error
        if (e.target.value && e.target.files[0].size > 16777215) {
            e.target.value = "";
            tooltip(jsonIdiomas[lang]['frontMessage']['1002'], 'error', document.querySelector('.mainAdmin'), 5000);
        }

    }

    if (e.target.classList.contains('numero') || e.target.classList.contains('paginas')) {
        // Si el valor es mayor que 99999, lo limitamos a 5 dígitos
        if (value > 99999) {
            e.target.value = e.target.value.slice(0, 5); // Limita a 5 caracteres
            tooltip(jsonIdiomas[lang]['frontMessage'][((e.target.classList.contains('numero')) ? '1004' : '1005')], 'error', document.querySelector('.mainAdmin'), 5000);
        }
    }

    // if (e.target.classList.contains('anio_publicacion')) {
    //     let hoy = new Date();
    //     let max = hoy.toISOString().split('T')[0];
    //     if (e.target.value >= max) {
    //         tooltip(jsonIdiomas[lang]['frontMessage']['1006'], 'error', document.querySelector('.mainAdmin'), 5000);
    //         e.target.value = '';
    //     }
    // }

    if (e.target.classList.contains('precio')) {
        if (e.target.value > 999999999.99) {
            e.target.value = e.target.value.slice(0, 12); // Limita a 12 caracteres (999999999.99)
            tooltip(jsonIdiomas[lang]['frontMessage']['1007'], 'error', document.querySelector('.mainAdmin'), 5000);
        }

        if (e.target.value.toString().split(".")[1] && e.target.value.toString().split(".")[1].length > 2) {
            // Redondea a dos decimales
            e.target.value = Math.trunc(e.target.value * 100) / 100; // Redondea a dos decimales
        }
    }

    if (e.target.classList.contains('stock')) {
        if (e.target.value.length > 10) {
            e.target.value = e.target.value.slice(0, 10); // Limita a 5 caracteres
            tooltip(jsonIdiomas[lang]['frontMessage']['1008'], 'error', document.querySelector('.mainAdmin'), 5000);
        }
    }

    if (tipo == 'number') {
        if (e.target.value < 0) {
            e.target.value *= -1; // Evita números negativos
        }
    }

});

async function construirPaginacionTablas(paginaActual, seccion) {

    let listaPaginacion = document.createElement('div');
    (localStorage.getItem('darkMode') == 'dark') ?
        listaPaginacion.classList.add('paginacion', 'theme--dark')
        : listaPaginacion.classList.add('paginacion');

    const respuestaArtistasPaginacion = await fetch(`index.php?controller=${seccion.controller}&action=obtenerNumeroElementos`);
    const numeroArtistas = await respuestaArtistasPaginacion.json();
    const respuestaArtistasPortPagina = await fetch(`index.php?controller=${seccion.controller}&action=elementosPorPagina`);
    const artistasPorPagina = await respuestaArtistasPortPagina.json();

    let paginas = Math.ceil(numeroArtistas / artistasPorPagina);

    for (let i = 1; i <= paginas; i++) {
        let a = document.createElement('a');
        a.textContent = i;
        if (i == paginaActual) {
            a.classList.add('active');
        }
        a.classList.add('numeroPaginacion');
        a.setAttribute('data-page', i);
        // a.setAttribute('href', `index.php?controller=Artista&action=obtenerArtistas&page=${i}`);
        listaPaginacion.appendChild(a);
    }
    if (document.querySelector('.paginacion')) {
        document.querySelector('.paginacion').remove();
    }
    document.querySelector('.mainAdmin').appendChild(listaPaginacion);
}

function construirTabla() {
    let formularioCrudProducto = document.getElementById('formProducto');

    formularioCrudProducto.innerHTML =/*html*/`
        <h1 class="titulo lang">${jsonIdiomas[lang]['mainAdmin']['producto']['title']}</h1>
        <table>
                <thead>
                    <tr>
                        <th class="lang" data-lang="ISBN_13" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['ISBN_13']}</th>
                        <th class="lang" data-lang="Portada" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Portada']}</th>
                        <th class="lang" data-lang="Nueva Portada" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Nueva Portada']}</th>
                        <th class="lang" data-lang="Nombre" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Nombre']}</th>
                        <th class="lang" data-lang="Autor" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Autor']}</th>
                        <th class="lang" data-lang="Trabajo" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Trabajo']}</th>
                        <th class="lang" data-lang="Coleccion" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Coleccion']}</th>
                        <th class="lang" data-lang="Numero" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Numero']}</th>
                        <th class="lang" data-lang="Tipo" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Tipo']}</th>
                        <th class="lang" data-lang="Formato" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Formato']}</th>
                        <th class="lang" data-lang="Páginas" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Páginas']}</th>
                        <th class="lang" data-lang="Género" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Género']}</th>
                        <th class="lang" data-lang="Editorial" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Editorial']}</th>
                        <th class="lang" data-lang="Año Publicación" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Año Publicación']}</th>
                        <th class="lang" data-lang="Sinopsis" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Sinopsis']}</th>
                        <th class="lang" data-lang="Precio" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Precio']}</th>
                        <th class="lang" data-lang="Stock" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Stock']}</th>
                        <th class="lang" data-lang="Acción" scope="col">${jsonIdiomas[lang]['mainAdmin']['producto']['th']['Acción']}</th>
                    </tr>
                </thead>
                
                <tbody class="productoCrud">
                `;

    const filaPromises = productos.map(producto => {
        return fetch(`index.php?controller=Producto&action=getArtista&parametro=${producto.isbn_13}`)
            .then(response => response.json())
            .then(artistaProducto => {
                return fetch(`index.php?controller=Artista&action=obtenerAutorPorId&parametro=${artistaProducto.artista_id}`)
                    .then(response => response.json())
                    .then(artista => {
                        let nombreArtista = artista.nombre + " " + artista.apellido1 + " " + artista.apellido2;
                        return `
                    <tr>
                     <td>
                     <input aria-label='ISBN13 del producto' class='isbn' name='isbn_13_[${producto.isbn_13}]' type='text' value='${producto.isbn_13}' readonly >
                     </td>
                     <td>
                     <img src='data:image/jpeg;base64,${producto.portada}' width='120px' alt='Portada de ${producto.nombre}-${producto.numero}'>
                     </td>
                     <td>
                     <input aria-label='Enlace para subir portada' type='file' name='portadaFile_[${producto.isbn_13}]' class='fileInput' id='fileInput_${producto.isbn_13}'>
                     <label for='fileInput_${producto.isbn_13}' class='fileInputLabel' class='lang' data-lang='subir'>${jsonIdiomas[lang]['mainAdmin']['botones']['subir']}</label>
                     </td>
                     <td>
                     <input aria-label='Nombre del producto' class='nombre' name='nombre_[${producto.isbn_13}]' type='text' value='${producto.nombre}'>
                     </td>
                     <td>
                     <input type='hidden' class='autor' name='autor_[${producto.isbn_13}]' type='hidden' value='${artistaProducto.artista_id}'>
                     <span>${nombreArtista}</span>
                     </td>
                     <td>
                     <select aria-label="Seleccione Trabajo del artista" class='trabajo' name='trabajo_[${producto.isbn_13}]'>
                     <option value='' disabled selected class='lang' data-lang='seleccione'>${jsonIdiomas[lang]['mainAdmin']['producto']['trabajos']['seleccione']}</option>
                     ${trabajos.map(trabajo => {
                            return `
                         <option  class='lang' data-lang='${trabajo}' value='${trabajo}' ${((trabajo == artistaProducto.trabajo) ? 'selected' : '')}>${jsonIdiomas[lang]['mainAdmin']['producto']['trabajos'][trabajo]}</option>
                         `
                        })}
                       </select>
                     </td>
                     <td>
                     <input aria-label='Coleccion a la que pertenece el producto' class='colleccion' name='coleccion_[${producto.isbn_13}]' type='text' value='${producto.coleccion}'>
                     </td>
                     <td>
                     <input aria-label='Número de la colección' class='numero' name='numero_[${producto.isbn_13}]' type='number' value='${producto.numero}'>
                     </td>
                     <td>
                     <select aria-label="Seleccione tipo de producto"<select class='tipo' name='tipo_[${producto.isbn_13}]'>
                     <option class="lang" data-lang="seleccione" value='' disabled selected>${jsonIdiomas[lang]['producto']['Tipo']['seleccione']}</option>

                    ${tipos.map(tipo => {
                            return `
                         <option class='lang' data-lang='${tipo}' value='${tipo}' ${((tipo == producto.tipo) ? 'selected' : '')}>${jsonIdiomas[lang]['producto']['Tipo'][tipo]}</option>
                         `
                        })}

                       </select>
                     </td>
                     <td>
                     <select aria-label="Seleccione el formato del producto" class='formato' name='formato_[${producto.isbn_13}]'>
                     <option class="lang" data-lang="seleccione" value='' disabled selected>${jsonIdiomas[lang]['producto']['Formato']['seleccione']}</option>

                    ${formatos.map(formato => {
                            return `
                         <option data-lang='${formato}' class='lang' value='${formato}' ${((formato == producto.formato) ? 'selected' : '')}>${jsonIdiomas[lang]['producto']['Formato'][formato]}</option>
                         `
                        })}

                       </select>
                     </td>
                     <td>
                     <input aria-label='Páginas del producto' class='paginas' name='paginas_[${producto.isbn_13}]' type='number' value='${producto.paginas}'>
                     </td>
                     <td>
                     <select aria-label="Seleccione el género del producto" class='subtipo' name='subtipo_[${producto.isbn_13}]'>
                     <option class="lang" data-lang="seleccione" value='' disabled selected>${jsonIdiomas[lang]['producto']['Subtipo']['seleccione']}</option>

                    ${subtipos.map(subtipo => {
                            return `
                         <option data-lang='${subtipo}' class='lang' value='${subtipo}' ${((subtipo == producto.subtipo) ? 'selected' : '')}>${jsonIdiomas[lang]['producto']['Subtipo'][subtipo]}</option>
                         `
                        })}

                       </select>
                     </td>
                     <td>
                     <input aria-label='Editorial que lo publica' class='editorial' name='editorial_[${producto.isbn_13}]' type='text' value='${producto.editorial}'>
                     </td>
                     <td>
                     <input aria-label='Año de publicación' class='anio_publicacion' name='anio_publicacion_[${producto.isbn_13}]' type='date' value='${producto.anio_publicacion}'>
                     </td>
                     <td>
                     <textarea aria-label='sinopsis del producto' class='sinopsis' name='sinopsis_[${producto.isbn_13}]' type='text'>${producto.sinopsis}</textarea>
                     </td>
                     <td>
                     <input aria-label='Precio del producto' class='precio' name='precio_[${producto.isbn_13}]' type='number' value='${producto.precio}' step='0.01'>
                     </td>
                     <td>
                     <input aria-label='stock del producto' class='stock' name='stock_[${producto.isbn_13}]' type='number' value='${producto.stock}'>
                     </td>
                     <td>
                     <input aria-label='Seleccione el producto para actualizar o eliminar' class='check' type='checkbox' name='check[${producto.isbn_13}]'>
                     </td>
                     </tr>
                     `
                    })
            })
    });

    Promise.all(filaPromises).then(filas => {
        formularioCrudProducto.querySelector('table>tbody').innerHTML += filas.join('');
    });
    formularioCrudProducto.innerHTML += `
    </tbody>
    </table>
        <div>
            <input type="submit" value="${jsonIdiomas[lang]['mainAdmin']['botones']['eliminar']}" class="btn btnTerciario lang theme--${themeDark}" name="eliminarProducto" data-lang="eliminar">
            <input type="submit" value="${jsonIdiomas[lang]['mainAdmin']['botones']['actualizar']}" class="btn btnPrimario lang theme--${themeDark}" name="actualizarProducto" data-lang="actualizar">
        </div>
    `;

}