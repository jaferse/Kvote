if (document.querySelector(".logeado")) {
    document.querySelector(".logeado").addEventListener("click", function () {
        //Mostrarmos el modal de login
        if (document.querySelector(".menuLogin").style.display == "block") {
            document.querySelector(".menuLogin").style.display = "none";   
        }else{
            // console.log("Menu Login visible");
            document.querySelector(".menuLogin").style.display = "block";
        }
    });

    document.addEventListener('click', function (event) {
        // console.log(event.target);

        if (!event.target.closest('.logeado') && !event.target.closest('.menuLogin')) {
            document.querySelector(".menuLogin").style.display = "none";
        }
    });
}