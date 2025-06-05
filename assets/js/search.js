const lupa = document.querySelector('.search > label');
const input = document.querySelector('.search>input');
lupa.addEventListener('click', () => {
    console.log("click");
    if (input.style.display == "block") {
        
        input.style.display = "none";
    }else{
        input.style.display = "block";
    }
})