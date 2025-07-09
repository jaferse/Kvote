document.addEventListener('DOMContentLoaded', async () => {

    const responseUser = await fetch(`index.php?controller=LogIn&action=verificarLogIn`);
    user = await responseUser.json();
    console.log(user);
    
    document.querySelector('.usuario').textContent = user.username;
});