<?php
namespace ProximaFecha\Controller;

use ProximaFecha\View\View;
use ProximaFecha\Core\Route;
use ProximaFecha\Core\Request;
use ProximaFecha\Model\Equipo;
use ProximaFecha\Model\Mensaje;
use ProximaFecha\Model\Posteo;
use ProximaFecha\Model\Usuario;
use ProximaFecha\Tools\Session;

class EquipoController
{


    /**
     * Método que muestra los equipos existentes
     */
    public function verEquipos()
    {
        $ruta = "";
        View::render('modulos/header',compact('ruta'));
        View::render('modulos/equipos', compact('ruta'));
        View::render('modulos/footer',compact('ruta'));
    }


    /**
     * Método que renderiza la vista de un Equipo en partícular
     */
    public function verEquipo()
    {
        $ruta = "../";
        $routeParams = Route::getRouteParams();
        $equipo_id = $routeParams['usuario_id'];
        if (Equipo::existeEquipo($equipo_id)) {
            $equipo = new Equipo($equipo_id);
            $equipo->setJugadores();
            Session::set("equipo_idActual",$equipo->getEquipoId());

            View::render('modulos/header',compact('ruta'));
            View::render('modulos/equipo', compact('ruta','equipo','equipo_id'));
            View::render('modulos/footer',compact('ruta'));

        } else{
            header("Location: ../error404");
        };
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