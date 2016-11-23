<?php
require_once 'DBConnection.php';


/**
 * Implementación de la clase Comida.
 */
class Comida implements JsonSerializable
{
    // Propiedades.
    protected $comida_id;
    protected $tipo_id;
    protected $nombre;
    protected $activa;
    protected $ingredientes;


    /**
     * Constructor: Si paso un ID ya obtiene los datos de la base de datos.
     * @param null $id
     */
    public function __construct($id = null)
    {
        if(!is_null($id)) {
            $this->getComidaPorID($id);
        }
    }

    /**
     * Especifica qué propiedades deben serializarse
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'comida' => $this->getComidaId(),
            'tipoComida' => $this->getTipoId(),
            'nombre' => $this->getNombre(),
            'activa' => $this->getActiva(),
            'ingredientes' => $this->getIngredientes(),
        ];
    }

    /**
     * Dado un ID carga en la instancia los datos de la comida asociada;
     * @param int $id
     */
    public function getComidaPorID($id)
    {
        $this->setComidaId($id);
        $query = "SELECT * FROM comidas WHERE comida_id = ?";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute([$this->getComidaId()]);
        $this->loadData($stmt->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Dado un array asociativo, setea los atributos
     * @param array $data
     */
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            $this->setAtributo($key,$value);
        }
    }


    /**
     * Dado un atributo y su valor, lo setea;
     * @param lowercase string key, mixed string value
     */
    private function setAtributo($key, $value)
    {
        switch ($key) {
            case 'comida_id':
                $this->setComidaId($value);
                break;
            case 'tipo_id':
                $this->setTipoId($value);
                break;
            case 'nombre':
                $this->setNombre($value);
                break;
            case 'activa':
                $this->setActiva($value);
                break;
        }
    }

    /**
     * Devuelve los inputs de tipo radio de las distintas comidas en base al where recibioo
     * @param string $whereAdicional
     * @return string
     */
    public static function printComidas( $whereAdicional){
        $rta = "";
        $where = "";
        if ($whereAdicional) {
            $where = "WHERE " . $whereAdicional;
        };
        $script = "SELECT c.comida_id, c.tipo_id, c.nombre FROM comidas c $where";
        $stmt = DBConnection::getStatement($script );
        $stmt->execute();

        while($filaComida = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $indiceComida = $filaComida['comida_id'];
            $dato = $filaComida['nombre'];
            $rta .=  "<label for='$dato'> $dato </label>";
            $rta .=  "<input id='$dato' type='radio' name='comida' value='$indiceComida' />";
        };
        return $rta;
    }

    /**
     * Inserta una comida y sus ingredientes, en base a los parámetros recibidos
     * @param $nombre
     * @param $tipo
     * @param $ingredientes
     * @return int|string
     * @throws ComidaNoGrabadaException
     */

    public static function insertarComida($nombre, $tipo_id, $ingredientes){
        $comida_id = 0;
        $vIngredientes = explode ( PHP_EOL  , $ingredientes);
        $comida= [
            'comida_id' => null,
            'tipo_id' => $tipo_id,
            'nombre' => $nombre,
            'activa' => '1'
        ];

        $script = "INSERT INTO comidas VALUES (:comida_id, :tipo_id, LCASE(:nombre) , :activa)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($comida)) {
            $comida_id  = DBConnection::getConnection()->lastInsertId();

            foreach( $vIngredientes as $i => $ingrediente){
                $script = "INSERT INTO ingredientes VALUES (null, :comida_id,  LCASE(:ingrediente))";
                $stmt = DBConnection::getStatement($script );
                $ingred= [
                    'comida_id' => $comida_id,
                    'ingrediente' => $ingrediente
                ];
                if (!$stmt->execute($ingred)){
                    throw new ComidaNoGrabadaException("Error al grabar el ingrediente en la comida.");
                }
            }

            return $comida_id;
        } else {
            throw new ComidaNoGrabadaException("Error al grabar la comida.");
        }
    }

    /**
     * Actualiza el estado de la comida en base al parámetro
     * @param string $estado
     * @throws ComidaNoGrabadaException
     */
    public function updateEstado( $estado){

        $script = "UPDATE comidas SET activa = :activa WHERE comida_id = :comida_id  ";
        $stmt = DBConnection::getStatement($script );
        $param = [
            'activa' => $estado,
            'comida_id' => $this->getComidaId()
            ];
        if(  $stmt->execute($param )) {
            $this->setActiva($estado);
            $this->getComidaPorID($this->getComidaId());
        }else{
            throw new ComidaNoGrabadaException("Error al grabar la comida.");
        }
    }



    /**
     * Trae un ID de comida en base a los parámetros agregados
     * @param $tipoComida : Minuta o Pizza
     * @param $condicionExtra : MAX | MIN | COUNT
     * @param $whereAdicional : Algun agregado a tener en cuenta para elegir la comida
     * @return string id de la comida que cumple el criterio
     */
    public static function get_ID_Comida( $tipoComida, $condicionExtra, $whereAdicional ){

        IF ( $tipoComida) {
            $whereAdicional = $whereAdicional . " AND tipo_id = '$tipoComida' ";
        };

        if ($condicionExtra) {
            $CampoSelect = $condicionExtra . "(comida_id)";
        }else{
            $CampoSelect = "comida_id";
        };

        $rta = "0";
        $script = "SELECT $CampoSelect AS comida_id FROM comidas WHERE  activa = 1  $whereAdicional LIMIT 1";
        $stmt = DBConnection::getStatement($script );
        $stmt->execute();

        if($filaComida = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rta = $filaComida['comida_id'];
        };
        return $rta;
    }


    /**
     * Método que trae los ingredientes de una comida
     * @return array|string
     *
     */
    public function getIngredientes()
    {
        $rta = "";
        $script = "SELECT GROUP_CONCAT(I.detalle SEPARATOR '</li><li>') AS ingredientes FROM comidas C , ingredientes I WHERE C.comida_id= I.comida_id AND C.activa = '1' AND C.comida_id = ? GROUP BY C.nombre";
        $stmt = DBConnection::getStatement($script);
        $stmt->execute([$this->comida_id]);
        if ($filaComida = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rta = $filaComida['ingredientes'];
        };
        return $rta;
    }


    /**
     * Devuelve si la instancia contiene una comida existente
     */
    public function esComida(){
        return ($this->getComidaId() > 0) ;
    }



    /**
     * Método que trae los ingredientes de una comida
     * @return boolean
     */
    public static function hayComidas()
    {
        $rta = "";
        $script = "SELECT 'X' FROM comidas WHERE activa = '1' ";
        $stmt = DBConnection::getStatement($script);
        $stmt->execute();
        return ($filaComida = $stmt->fetch(PDO::FETCH_ASSOC)) ;
    }


    /* SETTERS & GETTERS */
    /**
     * @return integer
     */
    public function getComidaId()
    {
        return $this->comida_id;
    }

    /**
     * @param integer $comida_id
     */
    public function setComidaId($comida_id)
    {
        $this->comida_id = $comida_id;
    }

    /**
     * @return integer
     */
    public function getTipoId()
    {
        return $this->tipo_id;
    }

    /**
     * @param integer $tipo_id
     */
    public function setTipoId($tipo_id)
    {
        $this->tipo_id = $tipo_id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getActiva()
    {
        return $this->activa;
    }

    /**
     * @param string $activa
     */
    public function setActiva($activa)
    {
        $this->activa = $activa;
    }
}