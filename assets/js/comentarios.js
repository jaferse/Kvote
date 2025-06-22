import { convertirFormatoFecha } from './funcionesGenericas.js';

/**
 * Devuelve el ISBN13 de un producto desde la URL actual
 * @param {string} nombre - El nombre del par metro en la URL
 * @returns {string} El ISBN13 del producto
 * @throws {Error} Si no se encuentra el par metro en la URL
 */
function getISBN13(nombre) {
    let URL = new URLSearchParams(window.location.search);
    let isbn = URL.get("isbn");
    if (isbn) {
        return isbn;
    } else {
        console.error("Error: No se ha encontrado el ISBN en la URL.");
    }

}

function construirComentario(comentario, index) {
    let fecha = convertirFormatoFecha(comentario.fecha);
    
    comentariosContainer.innerHTML += `
    <div>
    <div class="Producto__comentario" data-id="${comentario.id}">
    <h3>${comentario.titulo}</h3>
    <div class="Producto__comentario__info">
    <p><strong class="lang" data-lang="autor">Autor:</strong> ${comentario.autor_nombre} ${comentario.autor_apellido1}</p>
    <p><strong class="lang" data-lang="fechaComentario">Fecha:</strong> ${fecha}</p>
    </div>
    <p class="texto">${comentario.comentario}</p>
    </div>
    </div>
        `

    if (usuarioLogueadoId == comentario.usuario_id) {
        let divBotones = document.createElement("div");
        divBotones.classList.add("Producto__comentario__botones");
        let botonEditar = document.createElement("button");
        botonEditar.setAttribute("type", "submit");
        botonEditar.classList.add("Producto__comentarios__formulario__boton", "lang", "btn", "btnVerdePrimario");
        botonEditar.setAttribute("id", "editComment");
        botonEditar.setAttribute("data-lang", "editarComentario");
        let botonBorrar = document.createElement("button");
        botonBorrar.setAttribute("type", "submit");
        botonBorrar.classList.add("Producto__comentarios__formulario__boton", "lang", "btn", "btnRojo");
        botonBorrar.setAttribute("id", "deleteComment");
        botonBorrar.setAttribute("data-lang", "eliminarComentario");
        divBotones.appendChild(botonEditar);
        divBotones.appendChild(botonBorrar);
        productosComentarios.querySelectorAll('.Producto__comentario')[index].appendChild(divBotones);
    }
}

let comentariosContainer;
let productosComentarios;
let usuarioLogueadoId;
document.addEventListener('click', async function (event) {
    const responseLang = await fetch('assets/lang/es.json');
    const dataLang = await responseLang.json();
    let lang = localStorage.getItem("lang");
    //Comprobamos que se encuentre dentro de un formulario
    if (event.target.parentElement.tagName === "FORM") {
        event.preventDefault();
        let form = event.target.parentElement;
        //Si el elemento que se ha pulsado es el botón de nuevo comentario
        if (event.target.getAttribute("id") === "newComment") {
            form.action = "index.php?controller=Comentarios&action=nuevoComentario";
            form.requestSubmit();
        }
    }
    //Si se pulta editar
    if (event.target.getAttribute("id") === "editComment") {
        //Si el elemento que se ha pulsado es el botón de editar comentario
        let comentario = event.target.parentElement.parentElement;
        let idComentario = comentario.getAttribute("data-id");
        let titulo = comentario.querySelector("h3").textContent;

        let texto = comentario.querySelector(".texto").textContent;
        let form = document.createElement("form");
        form.classList.add("Producto__comentarios__formulario");
        form.setAttribute("id", `formComentario${idComentario}`);
        form.setAttribute("action", `index.php?controller=Comentarios&action=editarComentario`);
        form.setAttribute("method", 'POST');
        form.innerHTML = `
        <div class='Producto__comentarios__formulario__titulo'>
            <input class='Producto__comentarios__formulario__titulo__input lang' data-lang='tituloComentario' name='titulo' id='titulo' maxlength='100' placeholder='' value="${titulo}"></input>
        </div>
        <div>
            <textarea class='Producto__comentarios__formulario__texto lang' data-lang='escribeComentario' name='comentario' placeholder=''>${texto}</textarea>
        </div>
        <button type='submit' class='Producto__comentarios__formulario__boton btnVerdePrimario lang' id='editComment' data-lang='editarComentario'>${dataLang[lang]['comentarios']['editarComentario']}</button>
        <button type="button" class='Producto__comentarios__formulario__boton btnRojo lang' id='backComment' data-lang='atrasComentario'>${dataLang[lang]['comentarios']['atrasComentario']}</button>
        <input type='hidden' name='isbn13' id='isbn13' value='${getISBN13()}'>
        <input type='hidden' name='idComentario' id='idComentario' value='${idComentario}'>
        `;
        console.log(comentario);
        
        //ocultamos el comentario
        comentario.style.display = "none";
        
        //Añadimos el formulario
        comentario.parentNode.appendChild(form);

    }
    //Botón de atras
    if (event.target.getAttribute("id") === "backComment") {
        console.log("Boton atras");
        console.log(event.target.parentElement.parentElement);
        let comentarioDiv = event.target.parentElement.parentElement;
        comentarioDiv.querySelector(".Producto__comentario").style.display = "block"; 
        comentarioDiv.querySelector(".Producto__comentarios__formulario").remove(); 
    }

    if (event.target.getAttribute("id") === "deleteComment") {
        console.log("Eliminar comentario no implementado");
        console.log(event.target.parentElement.parentElement.getAttribute("data-id"));

        fetch(`index.php?controller=Comentarios&action=eliminarComentario&id=${event.target.parentElement.parentElement.getAttribute("data-id")}`, {
            method: 'DELETE',
        }).then(response => response.text())
            .then(data => {
                console.log("Comentario eliminado:", data);
                window.location.reload(); // Recargar la página para ver los cambios
            }).catch(error => {
                console.error("Error en la solicitud:", error);
            });
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    //obtenemos los comentarios del producto
    const response = await fetch(`index.php?controller=Comentarios&action=listarComentarios&isbn=${getISBN13("ISBN")}`)
    const data = await response.json();
    //obtenemos json de idioma
    const responseLang = await fetch('assets/lang/es.json');
    const dataLang = await responseLang.json();

    //obtenermos el login del usuario
    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    const user = await responseUser.json();
    usuarioLogueadoId = user.usernameId;
    if (document.querySelector('.nuevoComentario')) {
        document.querySelector('.nuevoComentario').textContent = '';
    }
    //Obtenemos el idioma del navegador
    let lang = localStorage.getItem("lang")
    productosComentarios = document.querySelector(".Producto__comentarios");
    comentariosContainer = document.querySelector(".Producto__comentarios__lista");

    data.forEach((comentario, index) => {
        construirComentario(comentario, index);
    });

    productosComentarios.querySelectorAll('.lang').forEach((element) => {
        if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
            element.setAttribute("placeholder", dataLang[lang]['comentarios'][element.getAttribute("data-lang")]);
        } else {

            element.textContent = dataLang[lang]['comentarios'][element.getAttribute("data-lang")];
        }
    });


    //Si no está logeado
    if (document.querySelector('.Producto__comentarios__nologueado')) {

        const divNologueado = document.querySelector('.Producto__comentarios__nologueado');
        divNologueado.addEventListener('click', () => {
            divNologueado.querySelector('.Producto__comentarios__formulario__boton').click();

        })
    }
});