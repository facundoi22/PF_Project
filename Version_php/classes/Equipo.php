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



    public static function CrearEquipo($nombre , $capitan){
        $usuario= [
            'nombre' => $nombre,
            'capitan_id'   =>  $capitan
        ];

        $script = "INSERT INTO EQUIPOS VALUES (null, :nombre, :capitan_id, 1)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($usuario)) {
            return DBConnection::getConnection()->lastInsertId();
        } else {
            throw new EquipoNoGrabadoException("Error al grabar el equipo.");
        }
    }


    public static function existeEquipo($equipo_id){
        $query = "SELECT 'X' FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $equipo_id]);
        return ($stmt->fetch(PDO::FETCH_ASSOC)) ;
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

    public function getEquipoId()
    {
        return $this->equipo_id;
    }
    public function getJugadores()
    {
        return $this->jugadores;
    }

    public function getNombre()
    {
        return $this->nombre;
    }


    /**
     * @return null|Torneo
     */
    public function getTorneo()
    {
        $query = "SELECT TORNEO_ID FROM EQUIPOS_TORNEO WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        if ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
           return new Torneo($datos['TORNEO_ID']);
        };
        return null;
    }

    public function participaEnTorneo()
    {
        $query = "SELECT 'X' FROM EQUIPOS_TORNEO WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        return ($stmt->fetch(PDO::FETCH_ASSOC)) ;
    }

    public function printJugadoresEnUL()
    {
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

            echo "<li><a href='index.php?seccion=miusuario&usuario_id=".$datos['JUGADOR_ID']."' title='Ver'><img src='images/usuarios/" . $datos['JUGADOR_ID'] . ".jpg' alt='Foto del Jugador " . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "'/></a><a href='index.php?seccion=miusuario&usuario_id=".$datos['JUGADOR_ID']."' title='Ver'><span ".$idCapitan.">" . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "</span>".$boton ."</a></li>";
        }
        echo "</ul>";
    }



    public static function imprimirEquiposEnUl()
    {
        echo "<ul id='ulTotalBusqueda'>";
        $query = "SELECT A.EQUIPO_ID, A.NOMBRE  , SUBSTR(GROUP_CONCAT(C.NOMBRE ,' ', C.APELLIDO , ' ') ,1,50)AS JUGADORES FROM EQUIPOS A, JUGADORES B , USUARIOS C WHERE A.EQUIPO_ID = B.EQUIPO_ID  AND B.JUGADOR_ID = C.USUARIO_ID AND A.ACTIVO = 1 AND C.ACTIVO = 1 GROUP BY A.EQUIPO_ID , A.NOMBRE
";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='liresultadobusqueda' >";
            echo "<div class='marcoEscudo' ><img src = 'images/equipos/". $datos['EQUIPO_ID']."_logo_150.jpg' alt = 'Logo Equipo ".$datos['EQUIPO_ID']."' style = 'margin:3px;' /></div >";
			echo "<div class='agruparDivs' ><div class='tituloResBusq' > ". $datos['NOMBRE'] ."</div >";
            echo "<div class='italicaResBusq' > Equipos: ". $datos['JUGADORES'] . "...</div ></div >";
            echo "<div class='divflechaCirculo'>";
            echo "<a href='index.php?seccion=miequipo&equipo_id=".$datos['EQUIPO_ID']."' title='Ver Equipo' ><img  class='flechaDerechaCirculo' src = 'images/icons/flechaderecha.png' alt = 'Ver Equipo' /></a >";
            echo "</div></li>";
            };
		echo "</ul>";
    }
}