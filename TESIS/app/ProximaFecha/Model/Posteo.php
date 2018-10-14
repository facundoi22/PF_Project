<?php
namespace ProximaFecha\Model;

use ProximaFecha\Tools\DBConnection;
use ProximaFecha\Exception\PosteoNoGrabadoException;

/**
 * Implementación de la clase Posteo
 */
class Posteo
{
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
    protected $titulo;
    /**
     * @var string
     */
    protected $contenido;

    /**
     * @var Usuario
     */
    protected $usuario;

    /**
     * @var Mensaje[];
     */
    protected $mensajes;

    /**
     * Posteo constructor.
     * @param string  $post
     * @param string[] $datos  - Contiene los datos a setear en el Posteo si no se lo quiere traer de la base
     */
    public function __construct($post = null, $datos = null )
    {
        $this->posteo_id = $post;
        if($datos){
            $this->usuario_id  = $datos['USUARIO_ID'];
            $this->titulo  = $datos['TITULO'];
            $this->contenido = $datos['CONTENIDO'];
        } else {
            $this->setPosteo();
        }
        $this->setMensajes();
        $this->setUsuario();
    }

    /**
     * Trae los datos de la base de datos del posteo asigando y lo guarda en la instancia
     */
    public function setPosteo()
    {
        $query = "SELECT USUARIO_ID, TITULO, CONTENIDO FROM POSTEOS WHERE POSTEO_ID = :posteo_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['posteo_id' => $this->posteo_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->usuario_id  = $datos['USUARIO_ID'];
            $this->titulo  = $datos['TITULO'];
            $this->contenido = $datos['CONTENIDO'];

        };
    }

    /**
     * @return string
     */
    public function getPosteoID()
    {
        return $this->posteo_id;
    }

    /**
     * @return string
     */
    public function getUsuarioID()
    {
        return $this->usuario_id;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }


    /**
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Inserta en la base de datos un Posteo nuevo en base a los parámetros recibidos.
     * * Si logra crearlo, devuelve el ID del posteo creado
     * @param $vPosteo
     * @return string
     * @throws PosteoNoGrabadoException
     */
    public static function CrearPosteo($vPosteo)
    {
        $posteo= [
            'usuario_id'   =>  $vPosteo['usuario'],
            'titulo'   => $vPosteo['titulo'],
            'contenido'   => nl2br( $vPosteo['contenido'])
        ];

        $script = "INSERT INTO POSTEOS VALUES (null, :usuario_id, :titulo, :contenido)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($posteo)) {
            return DBConnection::getConnection()->lastInsertId();
        } else {
            throw new PosteoNoGrabadoException("Error al grabar el posteo.");
        }
    }

    /**
     * Verifica en la base si existe un posteo con el ID recibido por parámetro
     * @param $posteo_id
     * @return mixed
     */
    public static function existePosteo ($posteo_id)
    {
        $query = "SELECT 'X' FROM POSTEOS WHERE POSTEO_ID = :posteo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['posteo_id' => $posteo_id ]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    /**
     * Trae de la base de datos todos los posteos y los guarda en un array;
     * @return array
     */
    public static function GetPosteos ($usuario_id = null)
    {
        $where ="";
        if ($usuario_id){
            $where = "WHERE USUARIO_ID = :usuario_id";
        } ;
        $query = "SELECT POSTEO_ID , USUARIO_ID, TITULO, CONTENIDO  FROM POSTEOS " . $where . " ORDER BY POSTEO_ID DESC";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id ]);
        $posteos = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $posteos[] = New Posteo($datos['POSTEO_ID'],$datos) ;
        }
        return $posteos;
    }

    /**
     * Trae los datos de la base de mensaje del posteo asigando y lo guarda en la instancia
     */
    protected function setMensajes()
    {
        $this->mensajes = Mensaje::GetMensajesDelPosteo($this->posteo_id);
    }

    /**
     * @return Mensaje[]
     */
    public function getMensajes()
    {
        return $this->mensajes;
    }

    /**
     * Instancia la variable de tipo Usuario en base al id de la instancia
     */
    protected function setUsuario()
    {
        $this->usuario = New Usuario($this->usuario_id);
    }
}