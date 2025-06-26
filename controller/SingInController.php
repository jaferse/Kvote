<?php
class SingInController
{

    private  $daousuario;
    private  $daologinDatos;
    private  $daotarjeta;
    public function __construct()
    {
        //Importamos las clases necesarias para el controlador
        require_once("model/usuario/UsuarioPDO.php");
        require_once("model/usuario/UsuarioClass.php");
        require_once("model/login_datos/Login_datosPDO.php");
        require_once("model/login_datos/Login_datosClass.php");
        require_once("model/tarjeta/TarjetaPDO.php");
        require_once("model/tarjeta/TarjetaClass.php");

        //Instanciamos objetos de las clases necesarias para el controlador
        $this->daousuario = new Daousuario(DDBB_NAME);
        $this->daologinDatos = new Daologin_datos(DDBB_NAME);
        $this->daotarjeta = new Daotarjeta(DDBB_NAME);
    }
    public function view()
    {
        require_once("./view/sing_in/sign_in.php");
    }


    public function registrar()
    {
        // var_dump();
        $datosUsuario = $this->daologinDatos->obtener($_POST['userName']);
        $datosUsuarioEmail = $this->daologinDatos->obtenerPorEmail($_POST['email']);
        $tarjetaNumero = str_replace("-", "", $_POST['tarjeta']);
        $datosTarjeta = $this->daotarjeta->obtener($tarjetaNumero);

        // echo $tarjetaNumero."<br>";
        // echo $datosTarjeta-> __get("numero_tarjeta")."<br>";

        //Comprobar que el usuario no existe, ni la tarjeta ni el email
        if (!$datosUsuario->__get("username") && !$datosUsuarioEmail->__get("email") && !$datosTarjeta->__get("numero_tarjeta")) {
            // echo "El usuario no existe";

            $usuario = new Usuario();
            //Devuelve el último id de la tabla usuario
            $id =  $this->daousuario->devovlerUltimoId() + 1;
            $usuario->__set("id", $id);
            $usuario->__set("nombre", $_POST['nombre']);
            $usuario->__set("apellido1", $_POST['apellido1']);
            $usuario->__set("apellido2", $_POST['apellido2']);
            $usuario->__set("birth", $_POST['birth']);


            //Creamos un objeto para la tabla login_datos
            $login = new Login_datos();
            $login->__set("username", $_POST['userName']);
            $login->__set("email", $_POST['email']);
            $hash = password_hash($_POST['password'], PASSWORD_ARGON2ID);
            $login->__set("password", $hash);
            $login->__set("usuario_id", $id);

            //Creamos un objeto para la tabla tarjeta
            $tarjeta = new Tarjeta();
            //Quitamos los guiones de la tarjeta
            
            $tarjeta->__set("numero_tarjeta", $tarjetaNumero);
            $tarjeta->__set("nombre_titular", $_POST['nombre']);
            $tarjeta->__set("emisor_tarjeta", $_POST['emisor_tarjeta']);
            // echo "<br>". $_POST['CVV'];
            $tarjeta->__set("cvv_cvc", $_POST['CVV']);
            $tarjeta->__set("tipo_tarjeta", $_POST['tipo_tarjeta']);
            //Comvertirmos la fecha de caducidad a formato YYYY-MM-DD
            $fecha = DateTime::createFromFormat('m/y', $_POST['caducidad']);
            // Formatear al formato MySQL 'YYYY-MM-DD'
            $fechaMysql = $fecha->format('Y-m-01');
            $tarjeta->__set("fecha_caducidad", $fechaMysql);
            $tarjeta->__set("usuario_id", $id);

            //Insertamos el objeto usuario en la base de datos
            $this->daousuario->insertar($usuario);
            //Insertamos el objeto login en la base de datos
            $this->daologinDatos->insertar($login);
            //Insertamos el objeto tarjeta en la base de datos
            $this->daotarjeta->insertar($tarjeta);
header("Location: index.php?controller=Index&action=view");
        } else {

            $codigoError = "";
            if ($datosUsuario->__get("username")) {
                $codigoError .= "El usuario ya existe <br>";
            }
            if ($datosUsuarioEmail->__get("email")) {
                $codigoError .= "El email ya existe <br>";
            }
            if ($datosTarjeta->__get("numero_tarjeta")) {
                $codigoError .= "El numero de tarjeta ya existe <br>";
            }

            echo "codigo error: ". $codigoError;
            //Redirigir al formulario de registro tras 3 segundos
            header("refresh:3;url=index.php?controller=SingIn&action=view");
        }
    }
}
