<?php

/**
 * Implementación de la clase Usuario
 */
class Usuario
{
    protected $usuario_id;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $activo;
    protected $telefono;
    protected $ultimaVez;

    protected $password;
    protected $equipos;
    protected $torneos;
    protected $torneosPropios;


    /**
     * Usuario constructor.
     * @param string $usu
     * @param null $pwd
     */
    public function __construct($usu , $pwd = null)
    {
        $this->usuario_id = $usu;
        if(!is_null($pwd)) {
            $this->password= SHA1($pwd);
        }
        $this->setUsuario();
        $this->setEquipos();
        $this->setTorneos();
        $this->setTorneosPropios();
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
        if($datos = $stmt->fetch(PDO::FETCH_ASSOC)){
            if ($datos['PASSWORD'] == $this->password){
                if ($datos['ACTIVO'] == '1'){
                    $rta = "";
                } else {
                    $rta = "El usuario no se encuentra activo";
                }
            } else {
                $rta = "La password es errónea";
            }

        } else {
            $rta = "El usuario no existe";
        }

        return $rta;
    }

    public function setEquipo($equipo)
    {
        $this->equipos[] = New Equipo($equipo);
    }

    public function setEquipos(){
        $this->equipos = [];
        $query = "SELECT EQUIPO_ID FROM JUGADORES WHERE JUGADOR_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->equipos[] = New Equipo($datos['EQUIPO_ID']);

        };
    }

    public function setTorneos(){
        $this->torneos = [];
        $query = "SELECT DISTINCT A.TORNEO_ID FROM TORNEOS A, EQUIPOS_TORNEO B , JUGADORES C WHERE A.TORNEO_ID = B.TORNEO_ID AND B.EQUIPO_ID = C.EQUIPO_ID AND C.JUGADOR_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->torneos[] = New Torneo($datos['TORNEO_ID']);
        };
    }

    public function setTorneosPropios(){
        $this->torneosPropios = [];
        $query = "SELECT DISTINCT A.TORNEO_ID FROM TORNEOS A, ORGANIZADORES B WHERE A.TORNEO_ID = B.TORNEO_ID AND B.ACTIVO = 1 AND B.ORGANIZADOR_ID =  :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->torneosPropios[] = New Torneo($datos['TORNEO_ID']);

        };
    }


    public function setUsuario()
    {
        $query = "SELECT NOMBRE, APELLIDO, EMAIL, ACTIVO, TELEFONO, ULTIMA_VEZ_ONLINE FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        if ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->apellido= $datos['APELLIDO'];
            $this->email = $datos['EMAIL'];
            $this->activo = $datos['ACTIVO'];
            $this->telefono = $datos['TELEFONO'];
            $this->ultimaVez = $datos['ULTIMA_VEZ_ONLINE'];
        };
    }

	public function tieneEquipo() {
	    return !empty($this->equipos[0]);
    }

    public function tieneTorneo() {
        return !empty($this->torneos[0]);
    }

    public function tieneTorneoPropio() {
        return !empty($this->torneosPropios[0]);
    }

    public function getEquipos(){
        return $this->equipos;
    }

    public function getTorneos(){
        return $this->torneos;
    }

    public function getTorneosPropios(){
        return $this->torneosPropios;
    }

    public function getUsuarioID(){
        return $this->usuario_id;
    }


    public function getNombre(){
        return $this->nombre;
    }


    public function getApellido(){
        return $this->apellido;
    }
    public function getNombreCompleto(){
        return $this->nombre . " " . $this->apellido;
    }

    public static function CrearUsuario($vUsuario){
        $usuario= [
            'usuario_id' => $vUsuario['usuario'],
            'password'   =>  SHA1($vUsuario['clave']),
            'nombre'     => ucfirst($vUsuario['nombre']),
            'apellido'   => ucfirst($vUsuario['apellido']),
            'email'      => ucfirst($vUsuario['email']),
            'activo'     => '1',
            'telefono'   => $vUsuario['telefono'],
            'ultima_vez' => date("Y-m-d")
        ];

        $script = "INSERT INTO USUARIOS  VALUES (:usuario_id, :password, :nombre , :apellido, :email, :activo, :telefono, :ultima_vez)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($usuario)) {
            return $vUsuario['usuario'];
        } else {
            throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
        }
    }

    public static function existeUsuario ($usuario_id){
        $query = "SELECT 'X' FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return ($stmt->fetch(PDO::FETCH_ASSOC)) ;
    }


    public static    function imprimir($aImprimir)
    {
        echo "<pre>";
        print_r($aImprimir);
        echo "</pre>";
    }

}