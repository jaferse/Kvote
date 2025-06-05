// Este script se encarga de cambiar la acción del formulario dependiendo del botón que se presione

let formProducto = document.getElementById('formProducto');

formProducto.addEventListener('submit', function (event) {
    event.preventDefault(); // Evita el envío del formulario por defecto
    
    // console.log('formProducto');
    event.target.name;
    //Sacamos el valor del botón que se ha presionado
    const botonPresionado = event.submitter.value; // Obtiene el valor del botón que disparó el evento
    // console.log(botonPresionado);
    
    // Controla la ruta en función del botón que se presiona
    switch (botonPresionado) {
        case 'Nuevo':
            // console.log('Nuevo');
            formProducto.action = "index.php?controller=Producto&action=create";
            break;
        case 'Actualizar':
            formProducto.action = "index.php?controller=Producto&action=actualizar";
            break;
        case 'Eliminar':
            formProducto.action = "index.php?controller=Producto&action=eliminar";
            break;
    }
    formProducto.submit(); // Envía el formulario con la nueva acción
});