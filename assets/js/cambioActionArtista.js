// Este script se encarga de cambiar la acción del formulario dependiendo del botón que se presione
import { cargarIdioma, ocultarSkeleton, mostrarSkeleton, tooltip } from './funcionesGenericas.js';

let formArtista = document.getElementById('formArtista');
let formArtistaCreate = document.getElementById('formArtistaCreate');

formArtista.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto
    let checkPulsados = 0;
    formArtista.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        if (checkbox.checked) {
            checkPulsados++;
        }

    });
    // Si se ha hecho click en el botón de actualizar o eliminar
    if (checkPulsados > 0) {
        formArtista.querySelectorAll('input[type="text"]').forEach(text => {
            text.value = text.value.trim(); // Elimina espacios en blanco al inicio y al final
        });

        //Sacamos el valor del botón que se ha presionado
        const botonPresionado = event.submitter.value; // Obtiene el valor del botón que disparó el evento
        // Controla la ruta en función del botón que se presiona
        switch (botonPresionado) {
            case 'Actualizar':
                formArtista.action = "index.php?controller=Artista&action=actualizar";
                break;
            case 'Eliminar':
                formArtista.action = "index.php?controller=Artista&action=eliminar";
                break;
        }
        formArtista.submit(); // Envía el formulario con la nueva acción
    }
    // Si no se ha pulsado ningún checkbox sacamos un tooltip de error
    else {
        tooltip('Debe seleccionar al menos un artista para actualizar o eliminar', 'error', document.querySelector('.mainAdmin'));
    }

});

formArtistaCreate.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto
    formArtistaCreate.querySelectorAll('input[type="text"]').forEach(text => {
        text.value = text.value.trim(); // Elimina espacios en blanco al inicio y al final
    });
    formArtistaCreate.submit();
});

let page;
let seccion;
let paises
let artistas
let respuestaPaises
let respuestaArtistas
let lang;
let jsonIdiomas;
document.addEventListener('DOMContentLoaded', async () => {
    page = 1;
    if (localStorage.getItem('seccion') === 'artistasCRUD') {
        const p = parseInt(localStorage.getItem('page'), 10);
        if (Number.isInteger(p) && p > 0) page = p;
    }
    if (localStorage.getItem('lang') === 'es' || localStorage.getItem('lang') === 'en' || localStorage.getItem('lang') === 'ja') {
        lang = localStorage.getItem('lang');
    }
    jsonIdiomas = await cargarIdioma();

    //Si hay un mensaje en localStorage, lo mostramos
    if (localStorage.getItem('flash_msg')) {
        tooltip(jsonIdiomas[lang]['backMessage'][JSON.parse(localStorage.getItem('flash_msg')).message], JSON.parse(localStorage.getItem('flash_msg')).type, document.querySelector('.mainAdmin'));
        localStorage.removeItem('flash_msg');
    }
    localStorage.setItem('seccion', 'artistasCRUD');
    localStorage.setItem('page', page);
    seccion = 'artistasCRUD';
    respuestaPaises = await fetch(`index.php?controller=Pais&action=listarPaises`);
    paises = await respuestaPaises.json();

    //listar artistas
    respuestaArtistas = await fetch(`index.php?controller=Artista&action=obtenerArtistas&page=${page}`)
    artistas = await respuestaArtistas.json();

    construirTabla();

    construirPaginacionTablas(page, { controller: 'Artista', container: '.mainAdmin' });

    ocultarSkeleton('block');
});

function construirTabla() {
    let formularioCrudArtista = document.querySelector('#formArtista>table>.artistaCrud');
    let hoy = new Date();
    let max = hoy.toISOString().split('T')[0]; // Formato YYYY-MM-DD

    const filaPromises = artistas.map(artista => {
        return fetch(`index.php?controller=Pais&action=obtenerPais&parametro=${artista.pais}`)
            .then(response => response.json())
            .then(paisArtista => {
                return `
                <tr>
                    <td><input aria-label="id de artista" id='id_${artista.id}' name='id_[${artista.id}]' type='text' value='${artista.id}' readonly></td>
                    <td><input aria-label="Nombre de artista" class='nombreAct' id='nombre_${artista.id}' name='nombre_[${artista.id}]' type='text' value='${artista.nombre}' required minlength="2" maxlength="50"></td>
                    <td><input aria-label="Primer apellido de artista" class='apellido1Act' id='apellido1_${artista.id}' name='apellido1_[${artista.id}]' type='text' value='${artista.apellido1}' required minlength="2" maxlength="45"></td>
                    <td><input aria-label="Segundo apellido de artista" class='apellido2Act' id='apellido2_${artista.id}' name='apellido2_[${artista.id}]' type='text' value='${artista.apellido2}' minlength="2" maxlength="45"></td>
                    <td>
                        <select aria-label="Seleccion de país" class='paisAct' id='pais_${artista.id}' name='pais_[${artista.id}]' required>
                            <option class="lang" data-lang="Seleccione" value='' disabled>${jsonIdiomas[lang]['paises']['Seleccione']}</option>
                            ${paises.map(pais => `
                                    <option class='lang' data-lang='${pais.nombre}' value='${pais.codigo_iso}' ${pais.codigo_iso === paisArtista.codigo_iso ? 'selected' : ''}>
                                         ${jsonIdiomas[lang]['paises'][pais.nombre]}
                                    </option>
                                `).join('')
                    }
                        </select>
                    </td>
                    <td><input aria-label="Fecha de nacimiento de artista" class='fecha_nacimientoAct' id='fecha_nacimiento_${artista.id}' name='fecha_nacimiento_[${artista.id}]' type='date' value='${artista.fecha_nacimiento}' max='${max}' required></td>
                    <td><input aria-label="Check de artista" type='checkbox' id='check${artista.id}' name='check[${artista.id}]'></td>
                </tr>
            `;
            });
    });

    Promise.all(filaPromises).then(filas => {
        formularioCrudArtista.innerHTML = filas.join('');
    });
}
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
        listaPaginacion.appendChild(a);
    }
    if (document.querySelector('.paginacion')) {
        document.querySelector('.paginacion').remove();
    }
    document.querySelector(seccion.container).appendChild(listaPaginacion);
}

document.addEventListener('click', async (e) => {
    if (e.target.tagName === 'A') {
        mostrarSkeleton('block');
        let numeroPagina = e.target.getAttribute('data-page');
        localStorage.setItem('page', numeroPagina);
        respuestaArtistas = await fetch(`index.php?controller=Artista&action=obtenerArtistas&page=${numeroPagina}`);
        artistas = await respuestaArtistas.json();
        construirTabla();
        construirPaginacionTablas(numeroPagina, { controller: 'Artista', container: '.mainAdmin' });
        ocultarSkeleton('block');
    }
});
