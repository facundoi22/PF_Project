<?php
namespace ProximaFecha\Model;

use ProximaFecha\Tools\DBConnection;
use ProximaFecha\Exception\ChatNoGrabadoException;
use ProximaFecha\Exception\MensajesNoLeidosException;

/**
 * Implementación de la clase Chat
 */
class Chat
{
    /**
     * @var string
     */
    protected $chat_id;
    /**
     * @var string
     */
    protected $emisor_id;
    /**
     * @var string
     */
    protected $receptor_id;

    /**
     * @var string
     */
    protected $leido;

    /**
     * @var string
     */
    protected $mensaje;


    /**
     * Mensaje constructor.
     * @param null $mens
     * @param null $datos. Si tiene datos , se crea el usuario con estos datos, sino trae los datos de la base.
     */
    public function __construct($mens = null, $datos = null )
    {
        $this->chat_id = $mens;
        if($datos) {
            $this->emisor_id  = $datos['EMISOR_ID'];
            $this->receptor_id  = $datos['RECEPTOR_ID'];
            $this->leido = $datos['LEIDO'];
            $this->mensaje = $datos['MENSAJE'];
        } else {
            $this->setChat();
        };
    }

    /**
     *  Trae de la base los datos del Chat instanciado, en base al ID de la isntancia.
     */
    public function setChat()
    {
        $query = "SELECT EMISOR_ID, RECEPTOR_ID,  MENSAJE FROM CHATS WHERE CHAT_ID = :chat_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['CHAT_ID' => $this->chat_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->emisor_id  = $datos['EMISOR_ID'];
            $this->receptor_id  = $datos['RECEPTOR_ID'];
            $this->leido = $datos['LEIDO'];
            $this->mensaje = $datos['MENSAJE'];
        };
    }

    /**
     * @return string
     */
    public function getEmisorID(){
        return $this->emisor_id;
    }

    /**
     * @return string
     */
    public function getReceptorID(){
        return $this->receptor_id;
    }

    /**
     * @return string
     */
    public function getLeido(){
        return $this->leido;
    }


    /**
     * @return string
     */
    public function getMensaje(){
        return $this->mensaje;
    }



    /**
     * Inserta en la base el Mensaje en base a los datos del parámetro vChat
     * Si logra crearlo, devuelve el ID del mensaje creado
     * @param $vChat
     * @return string
     * @throws ChatNoGrabadoException
     */
    public static function CrearChat($vChat){
        $mensaje= [
            'emisor_id' => $vChat['usuario_id'],
            'receptor_id'   =>  $vChat['amigo_id'],
            'mensaje'     => $vChat['mensaje']
        ];

        $script = "INSERT INTO CHATS VALUES (null, :emisor_id, :receptor_id, 'N', :mensaje)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($mensaje)) {
            return DBConnection::getConnection()->lastInsertId();
        } else {
            throw new ChatNoGrabadoException("Error al grabar el chat.");
        }
    }


    /**
     * Devuelve un array con todos los Mensajes que tengan se intercambien entre los usuarios pasados por parámetros
     * @param $emisor
     * @param $receptor
     * @return array
     */
    public static function GetConversacion ($emisor, $receptor)
    {
        $query = "SELECT CHAT_ID, EMISOR_ID, RECEPTOR_ID, LEIDO, MENSAJE FROM CHATS WHERE (EMISOR_ID = :emisor_id AND RECEPTOR_ID = :receptor_id ) OR (EMISOR_ID = :receptor_id AND RECEPTOR_ID = :emisor_id ) ORDER BY CHAT_ID ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['emisor_id' => $emisor, 'receptor_id' => $receptor]);
        $chats = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $chats [] = New Chat( $datos['CHAT_ID'] ,$datos );
        }
        return $chats ;
    }


    /**
     *  Actualiza el campo LEIDO en base a si el receptor vio los mensajes.
     * @param $usuario_id
     * @param $amigo_id
     * @throws MensajesNoLeidosException
     */
    public static function leerChats($usuario_id, $amigo_id)
    {
        $query = "UPDATE CHATS SET LEIDO ='Y' WHERE EMISOR_ID = :amigo_id AND RECEPTOR_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        if(!$stmt->execute(['usuario_id' => $usuario_id, 'amigo_id'=> $amigo_id ])) {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            throw new MensajesNoLeidosException("Error al leer los chats.");
        }
    }

    /**
     *  Verifica si hay líneas con el campo LEIDO=N en base al emisor y al receptor .
     */
    public static function HayChatsSinLeer($usuario_id, $amigo_id)
    {
        if ($usuario_id != $amigo_id) {
            $query = "SELECT DISTINCT 'Y' FROM CHATS WHERE EMISOR_ID = :amigo_id AND RECEPTOR_ID = :usuario_id AND LEIDO = 'N'";
        }else {
            $query = "SELECT DISTINCT 'Y' FROM CHATS WHERE :usuario_id  = :amigo_id AND RECEPTOR_ID = :usuario_id AND LEIDO = 'N'";
        }
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id, 'amigo_id' => $amigo_id ]);

        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


}