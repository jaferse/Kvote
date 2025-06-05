// Este script se encarga de cambiar la acción del formulario dependiendo del botón que se presione

let formArtista = document.getElementById('formArtista');

formArtista.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto
    // console.log('formArtista');
    
    //Sacamos el valor del botón que se ha presionado
    const botonPresionado = event.submitter.value; // Obtiene el valor del botón que disparó el evento
    // Controla la ruta en función del botón que se presiona
    switch (botonPresionado) {
        case 'Nuevo':
            // console.log('Nuevo');
            formArtista.action = "index.php?controller=Artista&action=create";
            break;
        case 'Actualizar':
            formArtista.action = "index.php?controller=Artista&action=actualizar";
            break;
        case 'Eliminar':
            formArtista.action = ".php?controllerindex=Artista&action=eliminar";
            break;
    }
    formArtista.submit(); // Envía el formulario con la nueva acción
});
