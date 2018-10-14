<?php
namespace ProximaFecha\Controller;

use ProximaFecha\View\View;
use ProximaFecha\Core\Route;
use ProximaFecha\Core\Request;
use ProximaFecha\Model\Mensaje;
use ProximaFecha\Model\Posteo;
use ProximaFecha\Model\Usuario;
use ProximaFecha\Tools\Session;

class HomeController
{

    /**
     * Método que renderiza el Home
     */
    public function index()
    {
        $ruta = "";
        View::render('modulos/header', compact('ruta'));
/*        $posteos = Posteo::GetPosteos();
        View::render('modulos/home', compact('ruta','posteos'));
*/
        View::render('modulos/home', compact('ruta'));
        View::render('modulos/footer', compact('ruta'));


    }
/**
    /**
     * Método que renderiza la vista de erorr en caso que algo falle
     *
    public function error404()
    {
        $ruta = "";
        View::render('modulos/header', compact('ruta'));
        View::render('modulos/error404', compact('ruta'));
        View::render('modulos/footer', compact('ruta'));

    }


    /**
     * Método que ordena el Insert de un mensaje si hay datos, y vuelve a la ubicación original;
     * @param Request $request
     *
     *
    public function agregarComentario(Request $request)
    {
        if (Session::has("usuario")){
           $inputs = $request->getData();
            if (!empty($inputs['mensaje'])) {
                $mensajeID = Mensaje::CrearMensaje($inputs);
            };
        header("Location: ../public#posteo".$inputs['posteo_id']);

        } else {
            header("Location: ../public");
        }
    }



    /**
     * Método que muestra el usuario que recibe como parámetro
     *
    public function verPosteos()
    {

        $ruta = "../";
        $routeParams = Route::getRouteParams();
        $usuario_id = $routeParams['usuario_id'];
        if (Usuario::existeusuario($usuario_id)) {
            View::render('modulos/header',compact('ruta'));
            $posteos = Posteo::GetPosteos($usuario_id);
            $usuarioActual = new Usuario($usuario_id);
            View::render('modulos/posteos', compact('ruta','posteos','usuarioActual'));
            View::render('modulos/footer',compact('ruta'));
        } else{
            header("Location: ../error404");
        };


    }


    /**
     * Método que ordena el Insert de un mensaje si hay datos, y vuelve a la ubicación original dentro de los posteos de un usuario;
     * @param Request $request
     *
     *
    public function agregarComentarioPosteos(Request $request)
    {
        if (Session::has("usuario")){
            $inputs = $request->getData();
            $usuarioAMostrar  ="";
            if (!empty($inputs['mensaje'])){
                try {
                    $mensajeID = Mensaje::CrearMensaje($inputs);
                } catch ( MensajeNoGrabadoException $exc){
                    echo "<pre>";
				    print_r($exc.getMessage());
				    echo "</pre>";
         
                    header("Location: ../error404");
                }

                $posteo = New Posteo($inputs['posteo_id']);
                $usuarioAMostrar =  $posteo->getUsuarioID();
            };

            header("Location: posteos/".$usuarioAMostrar);
        } else {
            header("Location: ../public");
        }

    }


    /**
     * Método que busca los usuarios que tengan un nombre o apellido que contenga el parámetro.
     *
    public function buscar(Request $request)
    {

        $ruta = "";
        $inputs = $request->getData();
        $dato = $inputs ['dato'];

        View::render('modulos/header',compact('ruta'));
        $resultados = Usuario::BuscarUsuarios($dato );
        View::render('modulos/resultados', compact('ruta','resultados'));
        View::render('modulos/footer',compact('ruta'));

    }
*/
}