<?php
namespace ProximaFecha\Controller;

use ProximaFecha\View\View;
use ProximaFecha\Core\Request;
use ProximaFecha\Core\Route;
use ProximaFecha\Model\Usuario;
use ProximaFecha\Model\Chat;
use ProximaFecha\Model\Posteo;
use ProximaFecha\Model\Equipo;
use ProximaFecha\Tools\Session;
use ProximaFecha\Tools\FormValidator;
use ProximaFecha\Exception\UsuarioNoGrabadoException;
use ProximaFecha\Exception\EquipoNoGrabadoException;
use ProximaFecha\Exception\AmigoNoGrabadoException;
use ProximaFecha\Exception\MensajesNoLeidosException;
use ProximaFecha\Exception\ChatNoGrabadoException;


class UsuarioController
{

    /**
     * Método que contorla la validación del usuario que se intenta loguear al sistema
     * @param Request $request
     **/
    public function loguear(Request $request)
    {
        $inputs = $request->getData();

        if (isset($inputs ["usuario"]) && !empty($inputs ["usuario"]) && isset($inputs ["password"]) && !empty($inputs ["password"])) {
            $usuario = New Usuario($inputs ['usuario'], $inputs ['password']);
            $error = $usuario->validarUsuario();
        } else {
            $error = "No ha ingresado el usuario o la contraseña";
        }

        if ($error){
            Session::set('errorLogin', $error);
            Session::clearValue('usuario');
            Session::clearValue('logueado');
            header("Location: ../public");
        } else {
            Session::clearValue('errorLogin');
            Session::set('usuario',$usuario);
            Session::set('logueado','S');
            header("Location: usuarios/".$usuario->getUsuarioID());
        }
    }



    /**
     * Método que controla el cierre de sesión
     * @param Request $request
     */
    public function desloguear(Request $request)
    {
    Session::clearValue('logueado');
    Session::clearValue('usuario');
    header("Location: ../public");
    }




    /**
     * Método que muestra el usuario que recibe como parámetro
     */
    public function ver()
    {
        $ruta = "../";
        $routeParams = Route::getRouteParams();
        $usuario_id = $routeParams['usuario_id'];
        if ($usuario_id ){
            if (Usuario::existeUsuario($usuario_id)) {
                $usuario = new Usuario($usuario_id);

                View::render('modulos/header',compact('ruta'));
                View::render('modulos/usuario', compact('ruta','usuario','usuario_id'));
                View::render('modulos/footer',compact('ruta'));

            } else{
                header("Location: ../error404");
            };
        } else {
            if (Session::has("usuario")) {
                $usuario = Session::get('usuario');
                $usuario_id = $usuario->getUsuarioID();
                View::render('modulos/header', compact('ruta'));
                View::render('modulos/usuario', compact('ruta', 'usuario', 'usuario_id'));
                View::render('modulos/footer', compact('ruta'));
            } else {
                header("Location: ../error404");
            };
        };
    }

    /**
     * Método que controla el registro de nuevos usuarios en el sistema.
     * @param Request $request
     */
    public function registrar(Request $request)
    {
        $inputs = $request->getData();
        $error =0;
        $errorActual = "";

        $formValidator = new FormValidator( $inputs);

        // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
        if ( !empty($formValidator->getCamposError()) ){
            Session::set("camposError",$formValidator->getCamposError());
            Session::set("campos",$formValidator->getCampos());
            header("Location: ../public#registroModal");
        } else {
            Session::clearValue("camposError");
            Session::clearValue("campos");

            try {
                $usuario_id = Usuario::CrearUsuario($inputs);
            } catch ( UsuarioNoGrabadoException $exc){
                echo "<pre>";
                print_r($exc.getMessage());
                echo "</pre>";
                header("Location: error404");
            }

            $usuario = New Usuario($usuario_id);
            Session::set('usuario',$usuario);
            Session::set('logueado','S');
            header("Location: usuarios/".$usuario_id);
        }
    }


    /**
     * Método que controla la creación de un posteo
     * @param Request $request
     */
    public function crear(Request $request)
    {
        if (Session::has("usuario")){
            $inputs = $request->getData();
            $files = $request->getFiles();

            try {
                $nombre = $inputs['nombre'];
                $capitan = $inputs['capitan'];
                $equipo_id = Equipo::CrearEquipo($nombre, $capitan);

            } catch (EquipoNoGrabadoException $exc){
                echo "<pre>";
                print_r($exc.getMessage());
                echo "</pre>";
                header("Location: ../error404");
            }

            if (isset($files['foto']['tmp_name']) && !empty($files['foto']['tmp_name'])) {
                $archivo_tmp = $files['foto']['tmp_name'];

                $original = imagecreatefromjpeg($archivo_tmp);
                $ancho = imagesx($original);
                $alto = imagesy($original);

                // Copia 200 px
                $alto_max= 200;
                $ancho_max = round( $ancho *  $alto_max / $alto );

                $copia = imagecreatetruecolor( $ancho_max, $alto_max );

                imagecopyresampled( $copia, $original,
                    0,0, 0,0,
                    $ancho_max,$alto_max,
                    $ancho,$alto);

                $nombre_nuevo = "../../public/images/equipos/$equipo_id"."_logo_200.jpg";
                imagejpeg( $copia , $nombre_nuevo);

                // Copia 100 px
                $alto_max= 100;
                $ancho_max = round( $ancho *  $alto_max / $alto );
                $copia = imagecreatetruecolor( $ancho_max, $alto_max );
                imagecopyresampled( $copia, $original,
                    0,0, 0,0,
                    $ancho_max,$alto_max,
                    $ancho,$alto);
                $nombre_nuevo = "../../public/images/equipos/$equipo_id"."_logo_100.jpg";
                imagejpeg( $copia , $nombre_nuevo);
            }
            header('Location: ../equipo/'.$equipo_id);
        } else {
            header("Location: ../public");
        }
    }



    /**
     * Método que muestra el usuario que recibe como parámetro
     *
    public function verPosteos()
    {

        $ruta = "";
        $routeParams = Route::getRouteParams();
        $usuario_id = $routeParams['usuario_id'];
        if (Usuario::existeusuario($usuario_id)) {
            $usuarioActual = new Usuario($usuario_id);
            View::render('modulos/header',compact('ruta'));
            $posteos = Posteo::GetPosteos( $usuario_id);
            View::render('modulos/home', compact('ruta','posteos'));

            View::render('modulos/footer',compact('ruta'));

        } else{
            header("Location: ../error404");
        };
    }

    /**
     * Método que agrega al amigo de un usuario.
     *
    public function agregarAmigo(Request $request)
    {
        if (Session::has("usuario")){
            $inputs = $request->getData();
            $amigo_id = "";
            if (!empty($inputs['amigo_id'])) {
                $amigo_id = $inputs['amigo_id'];
            };
            if (!empty($inputs['usuario_id'])){
                $usuario = New Usuario($inputs['usuario_id']);

                try {
                    $usuario->agregarAmigo($amigo_id );
                } catch ( AmigoNoGrabadoException $exc){
                    echo "<pre>";
		    		print_r($exc.getMessage());
			    	echo "</pre>";
                    header("Location: ../error404");
                }
            };
            header("Location: usuarios/".$amigo_id);
        } else {
            header("Location: ../public");
        }

    }


    /**
     * Método que elimina al amigo de un usuario.
     *
    public function eliminarAmigo(Request $request)
    {
        if (Session::has("usuario")){
            $inputs = $request->getData();
            $amigo_id = "";
            if (!empty($inputs['amigo_id'])) {
                $amigo_id = $inputs['amigo_id'];
            };
            if (!empty($inputs['usuario_id'])){
                $usuario = New Usuario($inputs['usuario_id']);
                $usuario->eliminarAmigo($amigo_id );
            };
            header("Location: usuarios/".$amigo_id);
        } else {
            header("Location: ../public");
        }

    }





    /**
     * Método que controla la actualización de la foto del perfil de usuario.
     * @param Request $request
     *
    public function actualizarFotoPerfil(Request $request)
    {
        if (Session::has("usuario")){
            $inputs = $request->getData();
            $files = $request->getFiles();

            $usuario = $inputs['usuario'];
            if (isset($files['foto']['tmp_name']) && !empty($files ['foto']['tmp_name'])){
                $archivo_tmp = $files ['foto']['tmp_name'];
                $original = imagecreatefromjpeg($archivo_tmp);
                $ancho = imagesx( $original );
                $alto = imagesy( $original );

                $alto_max= 200;
                $ancho_max = round( $ancho *  $alto_max / $alto );

                $copia = imagecreatetruecolor( $ancho_max, $alto_max );
                imagecopyresampled( $copia, $original,
                                    0,0, 0,0,
                                    $ancho_max,$alto_max,
                                    $ancho,$alto);

                $nombre_nuevo = "../views/images/usuarios/$usuario".".jpg";
                imagejpeg( $copia , $nombre_nuevo);
            }
            header("Location: ../usuarios/".$usuario);
         } else {
            header("Location: ../public");
        }
    }

    /**
     * Método que controla la actualización de los datos de un usuario
     * @param Request $request
     *
    public function actualizar(Request $request)
    {
        if (Session::has("usuario")){
            $inputs = $request->getData();
            $error =0;
            $errorActual = "";
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            $formValidator = new FormValidator( $inputs);

            // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
            if ( !empty($formValidator->getCamposError()) ){
                Session::set("camposError",$formValidator->getCamposError());
                Session::set("campos",$inputs);

                header("Location: ../usuarios/$usuario_id#registroModal");

            } else {
                Session::clearValue("camposError");
                Session::clearValue("campos");
                $inputs['usuario'] = $usuario_id ;


                try {
                    Usuario::ActualizarUsuario($inputs);
                } catch ( UsuarioNoGrabadoException  $exc){
                    echo "<pre>";
				    print_r($exc.getMessage());
				    echo "</pre>";
                    header("Location: ../error404" );
                }
                header("Location: ../usuarios/".$usuario_id );
            }
        } else {
            header("Location: ../public");
        }

    }


    /**
     * Método que muestra el chat entre el usuario conectado y el amigo elegido
     *
    public function mostrarChats(Request $request)
    {
        if (Session::has("usuario")){
            $ruta = "../../";
            $routeParams = Route::getRouteParams();
            $usuario_id = $routeParams['usuario_id'];
            $amigo_id = $routeParams['amigo_id'];
            if (Usuario::existeUsuario($usuario_id) && Usuario::existeUsuario($amigo_id))  {
                View::render('modulos/header',compact('ruta'));
                $usuarioActual = new Usuario($usuario_id);
                $amigoActual = new Usuario($amigo_id);
                $chats = $usuarioActual->getChatsCon($amigo_id);
                View::render('modulos/conversacion', compact('ruta','chats','usuarioActual','amigoActual'));
                View::render('modulos/footer',compact('ruta'));

                try {
                    $usuarioActual->leerChats($amigo_id);
                } catch (MensajesNoLeidosException $err)   {
                    alert($err.message);
                    header("Location: ../error404");
                }

            } else{
                header("Location: ../error404");
            };
        } else {
            header("Location: ../public");
        }

    }


    /**
     * Método que ordena el Insert de un Chat si hay datos, y vuelve a la ubicación original;
     * @param Request $request
     *
     *
    public function agregarChat(Request $request)
    {
        if (Session::has("usuario")) {
            $inputs = $request->getData();
            if (!empty($inputs['mensaje'])) {
                try {
                    $chatID = Chat::CrearChat($inputs);
                } catch (ChatNoGrabadoException $exc) {
                    echo "<pre>";
                    print_r($exc.getMessage());
                    echo "</pre>";
                    header("Location: ../error404");
                }
            };
            header("Location: ../public/chats/" . $inputs['usuario_id'] . "/" . $inputs['amigo_id']);
        } else {
            header("Location: ../public");
        }
    }
     * */
}

