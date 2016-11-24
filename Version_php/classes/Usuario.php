<?php

/**
 * Implementación de la clase Usuario
 */
class Usuario
{
    protected $usuario_id;
    protected $nombre;
    protected $password;
    protected $role_id;
    protected $activa;

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
    }


    public static function imprimir($aImprimir)
    {
        echo "<pre>";
        print_r($aImprimir);
        echo "</pre>";
    }

    /**
     * Valida el usuario instanciado existe en la base de datos y está activo;
     * @return string
     */
    public function validarUsuario(){
        $rta = "";
        $query = "SELECT ACTIVO FROM USUARIOS WHERE USUARIO_ID = :usuario_id AND PASSWORD = :password";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id'=> $this->usuario_id  , 'password'=>$this->password]);
        $this->imprimir ( $stmt->errorInfo());
        if($datos = $stmt->fetch(PDO::FETCH_ASSOC)){
            if ($datos['ACTIVO'] == '1'){
                $rta = "";
            } else {
                $rta = "El usuario no se encuentra activo";
            }
        } else {
            $rta = "El usuario o la password estan mal";
        }

        return $rta;
    }


	public function tieneEquipo() {
        $query = "SELECT equipo_id FROM jugadores WHERE jugador_id = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id'=> $this->usuario_id ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}