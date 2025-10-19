import { convertirFormatoFecha, getISBN13, cargarIdioma } from './funcionesGenericas.js';

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
        botonEditar.classList.add("Producto__comentarios__formulario__boton", "lang", "btn", "btnPrimario");
        botonEditar.setAttribute("id", "editComment");
        botonEditar.setAttribute("data-lang", "editarComentario");
        let botonBorrar = document.createElement("button");
        botonBorrar.setAttribute("type", "submit");
        botonBorrar.classList.add("Producto__comentarios__formulario__boton", "lang", "btn", "btnTerciario");
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
let dataLang;
document.addEventListener('click', async function (event) {
    let lang = localStorage.getItem("lang");
    //Comprobamos que se encuentre dentro del formulario de nuevo comentario
    if (event.target.parentElement.tagName === "FORM" && event.target.closest('#formNuevoComentario')) {
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
        form.innerHTML = /*html*/`
        <div class='Producto__comentarios__formulario__titulo'>
            <input class='Producto__comentarios__formulario__titulo__input lang' data-lang='tituloComentario' name='titulo' id='titulo' maxlength='100' placeholder='' value="${titulo}"></input>
        </div>
        <div>
            <textarea class='Producto__comentarios__formulario__texto lang' data-lang='escribeComentario' name='comentario' placeholder=''>${texto}</textarea>
        </div>
        <button type='submit' class='Producto__comentarios__formulario__boton btn btnPrimario lang' id='editar' data-lang='editarComentario'>${dataLang[lang]['comentarios']['editarComentario']}</button>
        <button type="button" class='Producto__comentarios__formulario__boton btn btnTerciario lang' id='backComment' data-lang='atrasComentario'>${dataLang[lang]['comentarios']['atrasComentario']}</button>
        <input type='hidden' name='isbn13' id='isbn13' value='${getISBN13()}'>
        <input type='hidden' name='idComentario' id='idComentario' value='${idComentario}'>
        `;

        //ocultamos el comentario
        comentario.style.display = "none";

        //Añadimos el formulario
        comentario.parentNode.appendChild(form);

    }
    
    //Botón de atrás
    if (event.target.getAttribute("id") === "backComment") {
        let comentarioDiv = event.target.parentElement.parentElement;
        comentarioDiv.querySelector(".Producto__comentario").style.display = "block";
        comentarioDiv.querySelector(".Producto__comentarios__formulario").remove();
    }

    if (event.target.getAttribute("id") === "deleteComment") {

        fetch(`index.php?controller=Comentarios&action=eliminarComentario&id=${event.target.parentElement.parentElement.getAttribute("data-id")}`, {
            method: 'DELETE',
        })
            .then(response => response.text())
            .then(data => {
                window.location.reload(); // Recargar la página para ver los cambios
            }).catch(error => {
                console.error("Error en la solicitud:", error);
            });
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    //obtenemos los comentarios del producto
    const response = await fetch(`index.php?controller=Comentarios&action=listarComentarios&isbn=${getISBN13()}`);
    const data = await response.json();
    //obtenemos json de idioma
    dataLang = await cargarIdioma();
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