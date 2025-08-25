<?php
require_once("core/funcionesGenericas.php");

class ComentariosController
{
    public function __construct()
    {

        session_start();

        require_once("model/comentario/ComentarioPDO.php");
        require_once("model/comentario/ComentarioClass.php");
        require_once("model/comentario/ComentarioDetalle.php");
        require_once("model/usuario/UsuarioPDO.php");
    }

    function nuevoComentario()
    {
        comprobarLogin();
        $comentario = new Comentario();
        $comentario->__set("usuario_id", $_SESSION['usernameId']);
        $comentario->__set("producto_isbn_13", $_POST['isbn13']);
        $comentario->__set("titulo", $_POST['titulo']);
        $comentario->__set("comentario", $_POST['comentario']);

        $comentarioPDO = new Daocomentario(DDBB_NAME);
        $comentarioPDO->insertar($comentario);
        header('location: index.php?controller=ProductoDetalle&action=view&isbn=' . $_POST['isbn13']);
    }

    function listarComentarios($isbn13)
    {
        $usuarioPDO = new DaoUsuario(DDBB_NAME);

        $comentarioPDO = new Daocomentario(DDBB_NAME);
        $comentarioPDO->obtenerPorISBN($isbn13);
        $arrayComentarios = array();
        foreach ($comentarioPDO->comentarios as $key => $value) {
            $usuario = $usuarioPDO->obtener($value->__get("usuario_id"));

            $comentarioDetalle = new ComentarioDetelle();
            $comentarioDetalle->__set("id", $value->__get("id"));
            $comentarioDetalle->__set("usuario_id", $value->__get("usuario_id"));
            $comentarioDetalle->__set("producto_isbn_13", $value->__get("producto_isbn_13"));
            $comentarioDetalle->__set("titulo", $value->__get("titulo"));
            $comentarioDetalle->__set("comentario", $value->__get("comentario"));
            $comentarioDetalle->__set("fecha", $value->__get("fecha"));
            $comentarioDetalle->__set("autor_nombre", $usuario->__get("nombre"));
            $comentarioDetalle->__set("autor_apellido1", $usuario->__get("apellido1"));
            $comentarioDetalle->__set("autor_apellido2", $usuario->__get("apellido2"));

            $arrayComentarios[] = $comentarioDetalle;
        }
        header('Content-Type: application/json');
        echo json_encode($arrayComentarios);
    }

    function eliminarComentario($id)
    {
        comprobarLogin();
        $comentarioPDO = new Daocomentario(DDBB_NAME);
        $comentarioPDO->borrar($id);
        $response['success'] = true;
        $response['id'] = $id;

        header('Content-Type: application/json');
        echo json_encode($response);
        // echo $_POST['isbn13'];
        // header('location: index.php?controller=ProductoDetalle&action=view&isbn='.$_POST['isbn13']);
    }

    function editarComentario()
    {
        comprobarLogin();
        echo $_POST['isbn13']."<br>";
        echo (new DateTime('now'))->format('Y-m-d H:i:s');
        $comentario = new Comentario();
        $comentario->__set("id", $_POST['idComentario']);
        $comentario->__set("usuario_id", $_SESSION['usernameId']);
        $comentario->__set("producto_isbn_13", $_POST['isbn13']);
        $comentario->__set("titulo", $_POST['titulo']);
        $comentario->__set("comentario", $_POST['comentario']);
        $comentario->__set("fecha",  (new DateTime('now'))->format('Y-m-d H:i:s'));

        $comentarioPDO = new Daocomentario(DDBB_NAME);
        $comentarioPDO->actualizar($comentario);
        header('location: index.php?controller=ProductoDetalle&action=view&isbn='. $_POST['isbn13']);

    }
}
