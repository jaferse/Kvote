<?php
class LogInController
{
    private $daologinDatos;
    public function __construct()
    {
        require_once("model/login_datos/Login_datosPDO.php");
        require_once("model/login_datos/Login_datosClass.php");
        $this->daologinDatos = new Daologin_datos(DDBB_NAME);
    }

    public function view()
    {
        require_once("./view/login/login.php");
    }

    /**
     * Comprueba si el usuario y contraseña enviados por post son correctos.
     * Si es asi, crea la sesion y redirige al inicio, si no, muestra un mensaje de error
     */
    public function logear()
    {
        session_start();
        // Busca que los datos que se han enviado están 
        // en la base de datos y si es asi mandalo 
        // de nuevo al inicio pero estando logueado

        $loginDatos = $this->daologinDatos->obtener($_POST['userName']);
        // echo $loginDatos->username . "<br>";
        // echo $_POST['userName'] . "<br>";
        // echo $loginDatos->password . "<br>";
        // echo  password_verify($_POST['password'], $loginDatos->password) . "<br>";
        // echo $_POST['password'] . "<br>";
        if ($loginDatos->username == $_POST['userName'] && password_verify($_POST['password'], $loginDatos->password)) {
            session_start();
            $_SESSION['logueado'] = true;
            $_SESSION['username'] = $loginDatos->username;
            $_SESSION['usernameId'] = $loginDatos->usuario_id;
            if ($loginDatos->admin == 1) {
                $_SESSION['admin'] = true;
            } else {
                $_SESSION['admin'] = false;
            }
            echo "Logueado <br>";
            header("Location: index.php?controller=Index&action=view");
        } else {
            echo "No logueado <br>";
            $_SESSION['logueado'] = false;
            $_SESSION['mensajeError'] = "El usuario o contraseña son incorrectos";
            header("Location: index.php?controller=LogIn&action=view");
        }
    }

    /**
     * Cierra la sesión actual y redirige a la página de inicio
     */
    function logOut()
    {
        session_start();
        session_destroy();
        header("Location: index.php?controller=Index&action=view");
    }


    function verificarLogIn()
    {
        session_start();
        $response = ['logueado' => false];
        if (
            isset($_SESSION['logueado'])
            && $_SESSION['logueado'] == true
            && isset($_SESSION['username'])
        ) {
            $response['logueado'] = true;
            $response['username'] = $_SESSION['username'];
            $response['usernameId'] = $_SESSION['usernameId'];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
