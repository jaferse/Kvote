// Este script se encarga de cambiar la acción del formulario dependiendo del botón que se presione
import { tooltip, cargarIdioma } from "./funcionesGenericas.js";
let formProducto = document.getElementById('formProducto');
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

    if (localStorage.getItem('seccion') === 'productoCRUD') {
        page = localStorage.getItem('page') || 1;
    } else {
        page = 1;
    }
    console.log('Pagina: '+page);
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

    construirTabla();
    construirPaginacionTablas(page, { controller: 'Producto', container: '.mainAdmin' });
});

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
    formProducto.submit(); // Envía el formulario con la nueva acción
});

document.addEventListener('click', async (e) => {

    if (e.target.tagName === 'A') {
        let numeroPagina = e.target.getAttribute('data-page');
        localStorage.setItem('page', numeroPagina);
        respuestaProductos = await fetch(`index.php?controller=Producto&action=obtenerProductosPaginado&page=${numeroPagina}`);
        productos = await respuestaProductos.json();
        construirTabla();
        construirPaginacionTablas(numeroPagina, { controller: 'Producto', container: '.mainAdmin' });
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
        <h1 class="titulo">Producto</h1>
        <table>
                <thead>
                    <tr>
                        <th scope="col">ISBN_13</th>
                        <th scope="col">Portada </th>
                        <th scope="col">Nueva Portada</th>
                        <th scope="col">Nombre </th>
                        <th scope="col">Autor </th>
                        <th scope="col">Trabajo</th>
                        <th scope="col">Coleccion </th>
                        <th scope="col">Numero</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Formato</th>
                        <th scope="col">Páginas</th>
                        <th scope="col">Género</th>
                        <th scope="col">Editorial</th>
                        <th scope="col">Año Publicación</th>
                        <th scope="col">Sinopsis</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Acción</th>
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
                     <input class='isbn' name='isbn_13_[${producto.isbn_13}]' type='text' value='${producto.isbn_13}' readonly >
                     </td>
                     <td>
                     <img src='data:image/jpeg;base64,${producto.portada}' width='120px'>
                     </td>
                     <td>
                     <input type='file' name='portadaFile_[${producto.isbn_13}]' class='fileInput' id='fileInput_${producto.isbn_13}'>
                     <label for='fileInput_${producto.isbn_13}' class='fileInputLabel'>Subir</label>
                     </td>
                     <td>
                     <input class='nombre' name='nombre_[${producto.isbn_13}]' type='text' value='${producto.nombre}'>
                     </td>
                     <td>
                     <input type='hidden' class='autor' name='autor_[${producto.isbn_13}]' type='hidden' value='${artistaProducto.artista_id}'>
                     <span>${nombreArtista}</span>
                     </td>
                     <td>
                     <select class='trabajo' name='trabajo_[${producto.isbn_13}]' id=''>
                     <option value='' disabled selected>Seleccione Trabajo</option>
                     ${trabajos.map(trabajo => {
                            return `
                         <option value='${trabajo}' ${((trabajo == artistaProducto.trabajo) ? 'selected' : '')}>${trabajo}</option>
                         `
                        })}
                       </select>
                     </td>
                     <td>
                     <input class='colleccion' name='coleccion_[${producto.isbn_13}]' type='text' value='${producto.coleccion}'>
                     </td>
                     <td>
                     <input class='numero' name='numero_[${producto.isbn_13}]' type='number' value='${producto.numero}'>
                     </td>
                     <td>
                     <select class='tipo' name='tipo_[${producto.isbn_13}]' id=''>
                     <option value='' disabled selected>Seleccione Formato</option>

                    ${tipos.map(tipo => {
                            return `
                         <option value='${tipo}' ${((tipo == producto.tipo) ? 'selected' : '')}>${tipo}</option>
                         `
                        })}

                       </select>
                     </td>
                     <td>
                     <select class='formato' name='formato_[${producto.isbn_13}]' id=''>
                     <option value='' disabled selected>Seleccione Formato</option>

                    ${formatos.map(formato => {
                            return `
                         <option value='${formato}' ${((formato == producto.formato) ? 'selected' : '')}>${formato}</option>
                         `
                        })}

                       </select>
                     </td>
                     <td>
                     <input class='paginas' name='paginas_[${producto.isbn_13}]' type='number' value='${producto.paginas}'>
                     </td>
                     <td>
                     <select class='subtipo' name='subtipo_[${producto.isbn_13}]' id=''>
                     <option value='' disabled selected>Seleccione Género</option>

                    ${subtipos.map(subtipo => {
                            return `
                         <option value='${subtipo}' ${((subtipo == producto.subtipo) ? 'selected' : '')}>${subtipo}</option>
                         `
                        })}

                       </select>
                     </td>
                     <td>
                     <input class='editorial' name='editorial_[${producto.isbn_13}]' type='text' value='${producto.editorial}'>
                     </td>
                     <td>
                     <input class='anio_publicacion' name='anio_publicacion_[${producto.isbn_13}]' type='date' value='${producto.anio_publicacion}'>
                     </td>
                     <td>
                     <textarea class='sinopsis' name='sinopsis_[${producto.isbn_13}]' type='text'>${producto.sinopsis}</textarea>
                     </td>
                     <td>
                     <input class='precio' name='precio_[${producto.isbn_13}]' type='number' value='${producto.precio}' step='0.01'>
                     </td>
                     <td>
                     <input class='stock' name='stock_[${producto.isbn_13}]' type='number' value='${producto.stock}'>
                     </td>
                     <td>
                     <input class='check' type='checkbox' name='check[${producto.isbn_13}]'>
                     </td>
                     </tr>
                     `
                    })
            })
    });

    Promise.all(filaPromises).then(filas => {
        formularioCrudProducto.querySelector('table>tbody').innerHTML += filas.join('');
        // formularioCrudProducto.innerHTML += filas.join('');
    });
    formularioCrudProducto.innerHTML += `
    </tbody>
    </table>
        <div>
            <input type="submit" value="Eliminar" class="btn btnTerciario" name="eliminarProducto">
            <input type="submit" value="Actualizar" class="btn btnPrimario" name="actualizarProducto">
        </div>
    `;

}