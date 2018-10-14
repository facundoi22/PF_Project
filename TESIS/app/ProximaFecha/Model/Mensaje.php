<?php
namespace ProximaFecha\Model;

use ProximaFecha\Tools\DBConnection;
use ProximaFecha\Exception\MensajeNoGrabadoException;

/**
 * Implementación de la clase Mensaje
 */
class Mensaje
{
    /**
     * @var string
     */
    protected $mensaje_id;
    /**
     * @var string
     */
    protected $posteo_id;
    /**
     * @var string
     */
    protected $usuario_id;
    /**
     * @var string
     */
    protected $mensaje;
    /**
     * @var Usuario
     */
    protected $usuario;

    /**
     * Mensaje constructor.
     * @param null $mens
     * @param null $datos. Si tiene datos , se crea el usuario con estos datos, sino trae los datos de la base.
     */
    public function __construct($mens = null, $datos = null )
    {
        $this->mensaje_id = $mens;
        if($datos) {
            $this->posteo_id  = $datos['POSTEO_ID'];
            $this->usuario_id  = $datos['USUARIO_ID'];
            $this->mensaje = $datos['MENSAJE'];
        } else {
            $this->setMensaje();
        };
        $this->usuario = New Usuario($this->usuario_id);
    }

    /**
     *  Trae de la base los datos del Mensaje instanciado, en base al ID de la isntancia.
     */
    public function setMensaje()
    {
        $query = "SELECT POSTEO_ID, USUARIO_ID, MENSAJE FROM MENSAJES WHERE MENSAJE_ID = :mensaje_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['mensaje_id' => $this->mensaje_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->posteo_id  = $datos['POSTEO_ID'];
            $this->usuario_id  = $datos['USUARIO_ID'];
            $this->mensaje = $datos['MENSAJE'];
        };
    }

    /**
     * @return string
     */
    public function getPosteoID(){
        return $this->posteo_id;
    }

    /**
     * @return string
     */
    public function getUsuarioID(){
        return $this->usuario_id;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * @return string
     */
    public function getMensaje(){
        return $this->mensaje;
    }

    /**
     * Inserta en la base el Mensaje en base a los datos del parámetro vMensaje
     * Si logra crearlo, devuelve el ID del mensaje creado
     * @param $vMensaje
     * @return string
     * @throws MensajeNoGrabadoException
     */
    public static function CrearMensaje($vMensaje){
        $mensaje= [
            'posteo_id' => $vMensaje['posteo_id'],
            'usuario_id'   =>  $vMensaje['usuario_id'],
            'mensaje'     => $vMensaje['mensaje']
        ];

        $script = "INSERT INTO MENSAJES VALUES (null, :posteo_id, :usuario_id, :mensaje)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($mensaje)) {
            return DBConnection::getConnection()->lastInsertId();
        } else {
            throw new MensajeNoGrabadoException("Error al grabar el mensaje.");
        }
    }


    /**
     * Devuelve un array con todos los Mensajes que tengan el posteo_id recibido por parámetro
     * @param $posteo
     * @return array
     */
    public static function GetMensajesDelPosteo ($posteo)
    {
        $query = "SELECT MENSAJE_ID, POSTEO_ID, USUARIO_ID, MENSAJE FROM MENSAJES WHERE POSTEO_ID = :posteo_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['posteo_id' => $posteo]);
        $mensajes = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $mensajes [] = New Mensaje( $datos['MENSAJE_ID'] ,$datos );
        }
        return $mensajes ;
    }



}