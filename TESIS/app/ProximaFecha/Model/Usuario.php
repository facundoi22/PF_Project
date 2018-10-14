<?php
namespace ProximaFecha\Model;

use ProximaFecha\Tools\DBConnection;
use ProximaFecha\Tools\Hash;
use ProximaFecha\Exception\UsuarioNoGrabadoException;
use ProximaFecha\Exception\AmigoNoGrabadoException;
use ProximaFecha\Exception\MensajesNoLeidosException;
use ProximaFecha\Model\Chat;
/**
 * Implementación de la clase Usuario
 */
class Usuario
{
    /**
     * @var string
     */
    protected $usuario_id;
    /**
     * @var string
     */
    protected $nombre;
    /**
     * @var string
     */
    protected $apellido;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $descripcion;
    /**
     * @var string
     */
    protected $activo;
    /**
     * @var string
     */
    protected $password;


    /**
     * Usuario constructor.
     * @param string $usu
     * @param null $pwd
     */
    public function __construct($usu , $pwd = null)
    {
        $this->usuario_id = $usu;
        if(!is_null($pwd)) {
            $this->password= $pwd;
        }
        $this->setUsuario();
    }



    /**
     * Valida el usuario instanciado existe en la base de datos y está activo;
     * @return string
     */
    public function validarUsuario(){
        $rta = "";
        $query = "SELECT PASSWORD, ACTIVO FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id'=> $this->usuario_id  ]);
        if($datos = $stmt->fetch(\PDO::FETCH_ASSOC)){
            if (Hash::verify($this->password,$datos['PASSWORD'] )){
                if ($datos['ACTIVO'] == '1'){
                    $rta = "";
                } else {
                    $rta = "El usuario no se encuentra activo";
                }
            } else {
                $rta = "La password es errónea" ;
            }
        } else {
            $rta = "El usuario no existe";
        }
        return $rta;
    }


    /**
     * Trae los datos de la base de datos del usuario asigando y lo guarda en la instancia
     */
    public function setUsuario()
    {
        $query = "SELECT NOMBRE, APELLIDO, EMAIL, DESCRIPCION, ACTIVO FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->apellido= $datos['APELLIDO'];
            $this->email = $datos['EMAIL'];
            $this->descripcion = $datos['DESCRIPCION'];
            $this->activo = $datos['ACTIVO'];
        };
    }

    /**
     * @return string
     */
    public function getUsuarioID(){
        return $this->usuario_id;
    }

    /**
     * @return string
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getApellido(){
        return $this->apellido;
    }

    /**
     * Devuelve el nombre y el apellido concatenados
     * @return string
     */
    public function getNombreCompleto(){
        return $this->nombre . " " . $this->apellido;
    }

    /**
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDescripcion(){
        return $this->descripcion;
    }

    /**
     * Inserta los datos del usuario en la base de datos en base al parámetro vUsuario recibido
     * Si sale bien, devuelve el ID del usaurio creado
     * @param $vUsuario Array of String
     * @return mixed
     * @throws UsuarioNoGrabadoException
     */
    public static function CrearUsuario($vUsuario){
        $usuario= [
            'usuario_id'  => $vUsuario['usuario'],
            'password'    =>  Hash::encrypt($vUsuario['clave']),
            'nombre'      => ucfirst($vUsuario['nombre']),
            'apellido'    => ucfirst($vUsuario['apellido']),
            'email'       => $vUsuario['email'],
            'activo'      => '1',
        ];

        $script = "INSERT INTO USUARIOS  VALUES (:usuario_id, :password, :nombre , :apellido, :email, null, :activo)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($usuario)) {
            return $vUsuario['usuario'];
        } else {
            throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
        }
    }


    /** Actualiza los datos del usuario en la base de datos en base al parámetro vUsuario recibido
     *  Si sale bien, devuelve el ID del usaurio actualizado
     * @param $vUsuario
     * @return mixed
     * @throws UsuarioNoGrabadoException
     */
    public static function ActualizarUsuario($vUsuario){
        $usuario= [
            'usuario_id'  => $vUsuario['usuario'],
            'nombre'      => ucfirst($vUsuario['nombre']),
            'apellido'    => ucfirst($vUsuario['apellido']),
            'email'       => $vUsuario['email'],
            'descripcion' => $vUsuario['descripcion'],

        ];

        $script = "UPDATE USUARIOS  SET NOMBRE = :nombre, APELLIDO = :apellido , EMAIL = :email , DESCRIPCION = :descripcion WHERE USUARIO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($usuario)) {
            return $vUsuario['usuario'];
        } else {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
        }
    }

    /**
     * Verifica en la base de datos si existe el usuario pasado por parámetro
     * @param $usuario_id
     * @return mixed
     */
    public static function existeUsuario ($usuario_id){
        $query = "SELECT 'X' FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    /**
     * Verifica en la base de datos si el usuario tiene algún amigo
     * @param $usuario_id
     * @return mixed
     */
    public function tieneAmigos (){
        $query = "SELECT 'X' FROM AMIGOS WHERE USUARIO_ID = :usuario_id OR AMIGO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' =>  $this->usuario_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }



    /**
     * Verifica en la base de datos si el usuario tiene como amigo al pasado por parámetro
     * @param $amigo_id
     * @return mixed
     */
    public function esAmigoDe ($amigo_id){
        $query = "SELECT 'X' FROM AMIGOS WHERE (USUARIO_ID = :usuario_id AND AMIGO_ID = :amigo_id) OR (USUARIO_ID = :amigo_id AND AMIGO_ID = :usuario_id)";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id, 'amigo_id' => $amigo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    /**
     * Agrega al amigo pasado por parámetro
     * @param $amigo_id
     * @return mixed
     * @throws AmigoNoGrabadoException
     */
    public function agregarAmigo ($amigo_id){
        $script = "INSERT INTO AMIGOS VALUES (:usuario_id, :amigo_id)";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute(['usuario_id' => $this->usuario_id, 'amigo_id' => $amigo_id])) {
            throw new AmigoNoGrabadoException("Error al grabar el amigo.");
        };
    }

    /**
     * Elimina al amigo pasado por parámetro
     * @param $amigo_id
     * @return mixed
     */
    public function eliminarAmigo ($amigo_id){
        $query = "DELETE FROM AMIGOS WHERE (USUARIO_ID = :usuario_id AND AMIGO_ID = :amigo_id) OR (USUARIO_ID = :amigo_id AND AMIGO_ID = :usuario_id)";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id, 'amigo_id' => $amigo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    /**
     * Devuelve un array con todos los Amigos que tengan el usuario
     * @param $posteo
     * @return array
     */
    public function getAmigos ()
    {
        $query = "SELECT AMIGO_ID FROM AMIGOS WHERE USUARIO_ID = :usuario_id UNION SELECT USUARIO_ID AS AMIGO_ID FROM AMIGOS WHERE  AMIGO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        $amigos = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $amigos [] = New Usuario( $datos['AMIGO_ID'] );
        }
        return $amigos ;
    }

    /**
     * Devuelve un array con todos los Chats entre el usuario y su amigo pasado por parámetro
     * @param $amigo_id
     * @return array
     */
    public function getChatsCon ($amigo_id)
    {
        return Chat::GetConversacion($this->usuario_id , $amigo_id) ;
    }

    /**
     * Actualiza los chats marcando que ya ha leído los suyos.
     * @param $amigo_id
     * @throws MensajesNoLeidosException
     */

    public function leerChats ($amigo_id)
    {
        return Chat::leerChats($this->usuario_id , $amigo_id) ;
    }

    /**
     * Verifica si tiene Chts sin haberse leído del usuario parasado por parámetro
     * @param $amigo_id
     * @return boolean
     */
    public function tieneMensajesDe ($amigo_id)
    {
        return Chat::HayChatsSinLeer($this->usuario_id , $amigo_id) ;
    }

    public static function BuscarUsuarios($dato )
    {
        $query = "SELECT USUARIO_ID FROM USUARIOS WHERE UPPER(NOMBRE) LIKE concat('%', UPPER(:dato) , '%')  OR UPPER(APELLIDO) LIKE concat('%', UPPER(:dato) , '%') ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['dato' => $dato]);
        $resultados = [];
        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $resultados [] = New Usuario( $datos['USUARIO_ID'] );
        }
        return $resultados ;
    }


    /**
     * Verifica si tiene Chts sin haberse leído
     * @return boolean
     */
    public function tieneMensajesSinLeer ()
    {
        return Chat::HayChatsSinLeer($this->usuario_id , $this->usuario_id ) ;
    }
}
