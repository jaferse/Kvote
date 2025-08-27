function calcularMapImg(fotos) {
    fotos.forEach((foto, key) => {
        let centro = foto.width / 2;
        // console.log(foto.width + "X" + foto.height);
        //Asignamos un usemap a la foto
        foto.setAttribute('usemap', `#mapa${key}`)

        //Creamos un mapa
        const mapa = document.createElement('map');
        mapa.setAttribute('name', `mapa${key}`)
        /*
        Creamos una area para colocar el botón de anterior,
        será desde 0,0 hasta 150,height 
        */
        const areaBefore = document.createElement('area');
        areaBefore.setAttribute("shape", "rect");
        areaBefore.setAttribute("coords", `0,0,80,${foto.height}`);
        areaBefore.setAttribute("class", "before");
        areaBefore.setAttribute("alt", "Atrás");

        //Creamos un area para el centro
        const areaCenter = document.createElement('area');
        areaCenter.setAttribute("shape", "rect");
        areaCenter.setAttribute("coords", `${80 + 50},0,${foto.width - 80 - 50},${foto.height}`);
        areaCenter.setAttribute("class", "center");
        areaCenter.setAttribute("href", enlacesCarrusel[key]);
        areaCenter.setAttribute("alt", "centro");
        /*
        Creamos una area para colocar el botón de siguiente,
        será desde 0,foto.width-150 hasta width,height 
        */
        const areaNext = document.createElement('area');
        areaNext.setAttribute("shape", "rect");
        areaNext.setAttribute("coords", `${foto.width - 80},0,${foto.width},${foto.height}`);
        areaNext.setAttribute("class", "next");
        areaNext.setAttribute("alt", "Siguiente");

        //Añadimos las areas a map
        mapa.appendChild(areaBefore);
        mapa.appendChild(areaCenter);
        mapa.appendChild(areaNext);

        //Añadimos el map a la foto
        foto.after(mapa);
    });
}

const enlacesCarrusel=[
    'http://localhost/index.php?controller=Catalogo&action=coleccion&parametro=Providence',
    'http://localhost/index.php?controller=Catalogo&action=coleccion&parametro=The%20Walking%20Dead',
    'http://localhost/index.php?controller=Catalogo&action=coleccion&parametro=Antonia%20Scott',
    'http://localhost/index.php?controller=Catalogo&action=coleccion&parametro=La%20Tierra%20Fragmentada',
    'http://localhost/index.php?controller=Catalogo&action=autor&parametro=Megan-Maxwell-',
    'http://localhost/index.php?controller=Catalogo&action=coleccion&parametro=Hay%20algo%20matando%20niños',
];


const sliderFrame = document.querySelector('.main__sliderFrame>ul');
let numeroImagenes = document.querySelectorAll('.main__sliderFrame>ul>li').length;
let currentIndex = 0;
let inicio = 0;

//Recalcular acho del contenedor
// console.log("Numero de imagenes: " + numeroImagenes);
sliderFrame.style.width = `${numeroImagenes * 100}%`;

// document.addEventListener('DOMContentLoaded', function () {
const fotos = document.querySelectorAll('.main__sliderFrame>ul>li>img');

// console.log(fotos.length);
calcularMapImg(fotos);







// });


/**
 * Calcular el tamaño del carrusel
*/
// document.addEventListener('DOMContentLoaded', () => {
//     let size = numeroImagenes * 100;
//     let numTransiciones = 100 / numeroImagenes;
//     console.log(numTransiciones);

//     sliderFrame.style.width = `${size}%`;
//     let adelante=true;
//    setInterval(() => {
//     if (adelante) {

//         inicio-=0.5;
//     }else{
//         inicio+=0.5;

//     }

//     if (inicio==-(100*(numeroImagenes-1))) {
//         adelante=false;
//     }
//     if (inicio==0) {
//         adelante=true;
//     }
//     sliderFrame.style.marginLeft = `${inicio}%`;
//     console.log(inicio);

//     if (Number.isInteger(inicio/100)) {
//         setTimeout(()=>{
//             console.log("Para");

//         },1000);
//     }
//    },30)
// });


const centerButton = document.querySelectorAll('.center');

centerButton.forEach(botonCentro => {

    botonCentro.addEventListener('click', (e) => {
        console.log(e.target);
        
    });
})

const beforeButton = document.querySelectorAll('.before');
beforeButton.forEach(botonAtras => {

    botonAtras.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentIndex > 0) {
            currentIndex--; // Retrocede una imagen
            let newMargin = -currentIndex * 100; // Calcula nuevo margen
            sliderFrame.style.marginLeft = `${newMargin}%`;
        }
    });
})
const nextButton = document.querySelectorAll('.next');
nextButton.forEach(botonAlante => {

    botonAlante.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentIndex < numeroImagenes - 1) {
            currentIndex++; // Avanza una imagen
            let newMargin = -currentIndex * 100; // Calcula nuevo margen
            sliderFrame.style.marginLeft = `${newMargin}%`;
        }
    });
});


