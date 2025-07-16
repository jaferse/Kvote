// Este script se encarga de cambiar la acción del formulario dependiendo del botón que se presione
import { tooltip, cargarIdioma } from "./funcionesGenericas.js";
let formProducto = document.getElementById('formProducto');

document.addEventListener('DOMContentLoaded', async () => {
    if (localStorage.getItem("flash_msg")) {
        let jsonIdiomas = await cargarIdioma();
        let lang = localStorage.getItem("lang") || 'es';
        let mensaje = JSON.parse(localStorage.getItem("flash_msg"));
        
        await tooltip(jsonIdiomas[lang]['crudProducto'][mensaje.message],mensaje.type,document.querySelector('.mainAdmin'));
        localStorage.removeItem("flash_msg");
    }
}); 

formProducto.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto

    event.target.name;
    //Sacamos el valor del botón que se ha presionado
    const botonPresionado = event.submitter.value; // Obtiene el valor del botón que disparó el evento
    // console.log(botonPresionado);

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