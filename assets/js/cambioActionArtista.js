// Este script se encarga de cambiar la acción del formulario dependiendo del botón que se presione

let formArtista = document.getElementById('formArtista');

formArtista.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    //Sacamos el valor del botón que se ha presionado
    const botonPresionado = event.submitter.value; // Obtiene el valor del botón que disparó el evento
    // Controla la ruta en función del botón que se presiona
    switch (botonPresionado) {
        case 'Nuevo':
            formArtista.action = "index.php?controller=Artista&action=create";
            break;
        case 'Actualizar':
            formArtista.action = "index.php?controller=Artista&action=actualizar";
            break;
        case 'Eliminar':
            formArtista.action = "index.php?controller=Artista&action=eliminar";
            break;
    }
    formArtista.submit(); // Envía el formulario con la nueva acción

});

let page;
let seccion;
let paises
let artistas
let respuestaPaises
let respuestaArtistas
document.addEventListener('DOMContentLoaded', async () => {
    ((localStorage.getItem('seccion') === 'artistasCRUD') ? page = localStorage.getItem('page') || 1 : page = 1);
    if (localStorage.getItem('seccion') === 'artistasCRUD') {
        page = localStorage.getItem('page') || 1;
    } else {
        page = 1;
    }
    localStorage.setItem('seccion', 'artistasCRUD');
    seccion = 'artistasCRUD';
    respuestaPaises = await fetch(`index.php?controller=Pais&action=listarPaises`);
    paises = await respuestaPaises.json();

    //listar artistas
    respuestaArtistas = await fetch(`index.php?controller=Artista&action=obtenerArtistas&page=${page}`)
    artistas = await respuestaArtistas.json();
    // console.log(artistas);

    construirTabla();

    construirPaginacionTablas(page,{controller:'Artista'});

})

function construirTabla() {
    let formularioCrudArtista = document.querySelector('#formArtista>table>.artistaCrud');
    // console.log(formularioCrudArtista);
    
    // formularioCrudArtista.innerHTML += `

    //                 <tr>
    //                 <th>ID</th>
    //                 <th>Nombre</th>
    //                 <th>Primer Apellido</th>
    //                 <th>Segundo Apellido</th>
    //                 <th>Pais</th>
    //                 <th>Fecha de Nacimiento</th>
    //                 <th>Acción</th>
    //             </tr>`;
    // artistas.forEach(artista => {
    //     // console.log(artista);
    //     //Listar pais del artista
    //     console.log("Foreach Artista: " +artista.id);
    //     fetch(`index.php?controller=Pais&action=obtenerPais&parametro=${artista.pais}`)
    //         .then(response => response.json())
    //         .then(paisArtista => {
    //             // console.log('paisArtista');
    //             // console.log(paisArtista);
    //             console.log("Foreach pais: " +artista.id);
    //             //obtenemos los paises
    //             formularioCrudArtista.innerHTML += `
    //             <tr>
    //                  <td>
    //                  <input name='id_[${artista.id}]' type='text' value='${artista.id}' readonly>
    //                  </td>

    //                  <td>
    //                  <input name='nombre_[${artista.id}]' type='text' value='${artista.nombre}'>
    //                  </td>

    //                  <td>
    //                  <input name='apellido1_[${artista.id}]' type='text' value='${artista.apellido1}'>
    //                  </td>

    //                  <td>
    //                  <input name='apellido2_[${artista.id}]' type='text' value='${artista.apellido2}'>
    //                  </td>

    //                  <td>
    //                     <select name='pais_[${artista.id}]'>
    //                         <option value='' disabled>Seleccione País</option>
    //                         ${
    //                         paises.map(pais=>
    //                             `
    //                             <option value='${pais.codigo_iso}'${((pais.codigo_iso == paisArtista.codigo_iso)? 'selected' :'')} >${pais.nombre}</option>
    //                             `).join('')
    //                         }
    //                     </select>
    //                  </td>

    //                  <td>
    //                  <input name='fecha_nacimiento_[${artista.id}]' type='date' value='${artista.fecha_nacimiento}'>
    //                  </td>

    //                  <td>
    //                  <input type='checkbox' name='check[${artista.id}]'>
    //                  </td>
    //             </tr>
    //            `
    //         });
    // })
    const filaPromises = artistas.map(artista => {
        return fetch(`index.php?controller=Pais&action=obtenerPais&parametro=${artista.pais}`)
            .then(response => response.json())
            .then(paisArtista => {
                return `
                <tr>
                    <td><input name='id_[${artista.id}]' type='text' value='${artista.id}' readonly></td>
                    <td><input name='nombre_[${artista.id}]' type='text' value='${artista.nombre}'></td>
                    <td><input name='apellido1_[${artista.id}]' type='text' value='${artista.apellido1}'></td>
                    <td><input name='apellido2_[${artista.id}]' type='text' value='${artista.apellido2}'></td>
                    <td>
                        <select name='pais_[${artista.id}]'>
                            <option value='' disabled>Seleccione País</option>
                            ${paises.map(pais => `
                                    <option value='${pais.codigo_iso}' ${pais.codigo_iso === paisArtista.codigo_iso ? 'selected' : ''}>
                                        ${pais.nombre}
                                    </option>
                                `).join('')
                    }
                        </select>
                    </td>
                    <td><input name='fecha_nacimiento_[${artista.id}]' type='date' value='${artista.fecha_nacimiento}'></td>
                    <td><input type='checkbox' name='check[${artista.id}]'></td>
                </tr>
            `;
            });
    });

    Promise.all(filaPromises).then(filas => {
        formularioCrudArtista.innerHTML = filas.join('');
    });

}
async function construirPaginacionTablas(paginaActual, seccion) {
    // console.log("Pagina actual: "+paginaActual);
    
    let listaPaginacion = document.createElement('div');
    (localStorage.getItem('darkMode') == 'dark') ?
        listaPaginacion.classList.add('paginacion', 'theme--dark')
        : listaPaginacion.classList.add('paginacion');
// console.log(seccion.controller);

    const respuestaArtistasPaginacion = await fetch(`index.php?controller=${seccion.controller}&action=obtenerNumeroElementos`);
    const numeroArtistas = await respuestaArtistasPaginacion.json();
    const respuestaArtistasPortPagina = await fetch(`index.php?controller=${seccion.controller}&action=elementosPorPagina`);
    const artistasPorPagina = await respuestaArtistasPortPagina.json();

    let paginas = Math.ceil(numeroArtistas / artistasPorPagina);
    // console.log("Paginas: "+paginas);
    
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

document.addEventListener('click', async (e) => {
    
    if (e.target.tagName==='A') {
        // console.log(e.target.getAttribute('data-page'));
        let numeroPagina=e.target.getAttribute('data-page');
        localStorage.setItem('page', numeroPagina);
        respuestaArtistas = await fetch(`index.php?controller=Artista&action=obtenerArtistas&page=${numeroPagina}`);
        artistas = await respuestaArtistas.json();
        construirTabla();
        construirPaginacionTablas(numeroPagina,{controller:'Artista'});
    }


});
