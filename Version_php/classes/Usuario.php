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
    protected $equipo;


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
        $this->setEquipo();
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

    public function setEquipo($equipo = null)
    {
        if ($equipo) {
            $this->equipo = New Equipo($equipo );
        } else {
            $query = "SELECT EQUIPO_ID FROM JUGADORES WHERE JUGADOR_ID = :usuario_id ";
            $stmt = DBConnection::getStatement($query);
            $stmt->execute(['usuario_id' => $this->usuario_id]);
            if ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->equipo = New Equipo($datos['EQUIPO_ID']);
            }
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
	    return !empty($this->equipo);
    }

    public function getEquipo(){
        return $this->equipo;
    }

}