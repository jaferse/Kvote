import { cargarIdioma, crearDialogo } from "./funcionesGenericas.js";
import { darseBajaTraduccir } from "./lang.js";
document.addEventListener('DOMContentLoaded', async () => {

    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    const user = await responseUser.json();
    const idiomasJson = await cargarIdioma();
    console.log(idiomasJson);
    let lang= localStorage.getItem('lang', user.idioma);
    darseBajaTraduccir(idiomasJson, lang);

    document.querySelector('.usuario').textContent = user.username;

    document.addEventListener('click', async (event) => {
        let id = event.target.getAttribute('id');

        //Si se ha hecho click en un enlace del menú lateral
        if (id === 'baja' || id === 'tarjetaCredito' || id === 'direcciones' || id === 'passWord' || id === 'datosPersonales') {
            //Ocultar el resto de los contenedores
            ocultarContenedores();

            //Mostrar el contenedor de baja
            const classContainer = `.container${id.charAt(0).toUpperCase() + id.slice(1)}`;
            document.querySelector(classContainer).style.display = 'flex';
        }

        //Si se ha hecho click en el botón de formalizar baja
        if (event.target.closest('.btnBaja')) {
            //Redirigir a la página de baja
            try {
                const responseBaja = await fetch(`index.php?controller=Perfil&action=baja&username=${user.username}`);
                const baja = await responseBaja.text();
                crearDialogo(
                    {
                        title: 'Baja formalizada',
                        message: 'Baja formalizada correctamente',
                        mensajeAceptar: 'Aceptar',
                        mensajeCancelar: 'Registrarme',
                    },
                    () => {
                        window.location.href = `index.php?controller=Index&action=view`;
                    },
                    () => {
                        window.location.href = `index.php?controller=SingIn&action=view`;
                    }
                )
                window.location.href = `index.php?controller=Index&action=view`;
            } catch (error) {
                console.error(error);
            }
            console.log(baja);
            
        }

    });
});

function ocultarContenedores() {
    document.querySelectorAll('.container').forEach(container => {
        container.style.display = 'none';
    });
}