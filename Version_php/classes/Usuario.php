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




    /**
     * Valida el usuario instanciado existe en la base de datos y está activo;
     * @return string
     */
    public function validarUsuario(){
        $rta = "";
        $query = "SELECT activa FROM usuarios WHERE usuario_id = :usuario_id AND password = :password";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id'=> $this->usuario_id  , 'password'=>$this->password]);
        if($datos = $stmt->fetch(PDO::FETCH_ASSOC)){
            if ($datos['activa'] == '1'){
                $rta = "";
            } else {
                $rta = "El usuario no se encuentra activo";
            }
        } else {
            $rta = "El usuario o la password estan mal";
        }
        return $rta;
    }


    /**
     * Verifica si el usuario instanciado tiene el rol pasado por parámetro
     * @param $rol
     * @return mixed
     */
    public function tieneRol($rol ) {
        $query = "SELECT usuario_id FROM usuarios WHERE usuario_id = :usuario_id AND role_id = :role_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id'=> $this->usuario_id  , 'role_id'=>$rol]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

	public function tieneEquipo() {
        $query = "SELECT equipo_id FROM equipos WHERE usuario_id = :usuario_id AND ACTIVO = '1'";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id'=> $this->usuario_id );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}