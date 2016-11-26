<?php

/**
 * Implementación de la clase Equipo
 */
class Equipo
{
    /**
     * @var string
     */
    protected $equipo_id;
    /**
     * @var string
     */
    protected $nombre;
    /**
     * @var string
     */
    protected $capitan_id;

    /**
     * @var array of Usuario;
     */
    protected $jugadores;

    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($equi = null)
    {
        if(!is_null($equi)) {
            $this->setEquipo($equi);
        }
    }



    public function setEquipo($equi)
    {
        $this->equipo_id = $equi;

        $query = "SELECT NOMBRE, CAPITAN_ID FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        if ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->capitan_id = $datos['CAPITAN_ID'];
        };
        $this->jugadores = [];
    }


    public function setJugadores()
    {
        $this->jugadores = [];
        $query = "SELECT JUGADOR_ID FROM JUGADORES WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->jugadores[] = New Usuario($datos['JUGADOR_ID']);
        };
    }

    public function getEquipoId(){
        return $this->equipo_id;
    }
    public function getJugadores(){
        return $this->jugadores;
    }

    public function getNombre(){
        return $this->nombre;
    }


    public static function imprimir($aImprimir)
    {
        echo "<pre>";
        print_r($aImprimir);
        echo "</pre>";
    }

    /**
     * @return null|Torneo
     */
    public function getTorneo(){

        $query = "SELECT TORNEO_ID FROM EQUIPOS_TORNEO WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        if ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
           return new Torneo($datos['TORNEO_ID']);
        };
        return null;
    }

    public function participaEnTorneo(){

        $query = "SELECT 'X' FROM EQUIPOS_TORNEO WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        return ($stmt->fetch(PDO::FETCH_ASSOC)) ;
    }

    public function printJugadoresEnUL(){
        echo"<ul>";
        $query = "SELECT A.JUGADOR_ID, B.NOMBRE , B.APELLIDO FROM JUGADORES A, USUARIOS B WHERE A.JUGADOR_ID = B.USUARIO_ID AND A.EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            IF ($datos['JUGADOR_ID'] == $this->capitan_id){
                $idCapitan = "id='capitan'";
                $boton = "<a href='#mensajeModal' class='mayuscula'>Enviar Mensaje</a>";
            } else {
                $idCapitan = "";
                $boton = "";
            }

            echo "<li><a href='index.php?seccion=miusuario&usuario_id=".$datos['JUGADOR_ID']."' title='Ver'><img src='images/usuarios/" . $datos['JUGADOR_ID'] . ".jpg' alt='Foto del Jugador " . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "'/></a><span ".$idCapitan.">" . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "</span>".$boton ."</li>";
        }
        echo "</ul>";
    }


    public static function existeEquipo ($equipo_id){
        $query = "SELECT 'X' FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $equipo_id]);
        return ($stmt->fetch(PDO::FETCH_ASSOC)) ;
    }

}