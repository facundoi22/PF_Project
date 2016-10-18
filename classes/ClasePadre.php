<?php

/**
 * Clase que sirve para crear clases hijas usando este constructor
 */

require_once 'DBConnection.php';
require_once '../exceptions/ParametroInvalidoException.php';
require_once '../exceptions/StatementInvalidoException.php';
require_once '../exceptions/ClavesExistentesException.php';
class ClasePadre
{

    protected static $tabla;

    public static $atributosPermitidos = [];
    public static $clavesPermitidas = [];

    protected $campos = [];
    protected $claves = [];

    /**
     * ClasePadre constructor.
     * @param $tabla
     * @param null $pk
     */
    public function __construct($tabla, $pk = null)
    {
        static::$tabla = $tabla;
        if (sizeof(static::$atributosPermitidos) == 0){
            $this->cargarAtributos();
        }
        if(!is_null($pk)) {
            $this->findByPk($pk);
        }
    }


    /**
     * @param array $pk
     */
    public function findByPk($pk)
    {

        $this->cargarClaves($pk);
        $query = $this->getSelectByKeys();
        $stmt = DBConnection::getStatement($query);

        $stmt->execute($this->claves);
        $this->loadData($stmt->fetch(PDO::FETCH_ASSOC));
    }


    protected function getSelectByKeys()
    {
        $select = "SELECT " . implode(", ", static::$atributosPermitidos) ;
        $from = " FROM " . static::$tabla ;
        $where = " WHERE ";
        $and = null;
        foreach ($this->claves as $key => $value) {
            $where .= $and  . $key  . " = :" . $key ;
            if (is_null($and)){
                $and = " AND ";
            }
        }

        return ($select . $from . $where );
    }


    /**
     * @param array $data
     */
    public function loadData($data)
    {
        if(!is_array($data)) return;

        foreach ($data as $key => $value) {
            if(in_array($key, static::$atributosPermitidos)) {
                $this->campos[$key] = $value;
                //$this->{$key} = $value;
            }
        }
    }

    /**
     * @return array|Pelicula[]
     *
    public static function findAll()
    {
    $query = "SELECT * FROM users";
    $stmt = DBConnection::getStatement($query);
    $stmt->execute();
    $salida = [];
    while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $user = new User;
    $user->setIdUser($fila['id_user']);
    $user->loadData($fila);
    $salida[] = $user;
    }
    return $salida;
    }
     */


    /**
     * Crea una User nueva en la base de datos.
     *
     * @param $data
     * @return User
     * @throws Exception
     */
    public static function create($data)
    {
        if (static::ExistenClaves($data)){
            throw new ClavesExistentesException("Las Claves ya existen en base de datos");
        } else {
            $data = static::filterData($data);
            $query = static::generateInsertQuery($data);
            //echo $query;
            $stmt = DBConnection::getStatement($query);
            //static::imprimir($data);
            if ($stmt->execute($data)) {
                return DBConnection::getConnection()->lastInsertId();
            } else {
                static::imprimir($stmt->errorInfo());
                throw new StatementInvalidoException("Error al grabar un nuevo registor.");
            }
        }
    }

    /**
     * Filtra la $data para que sea acorde a los $atributosPermitidos.
     *
     * @param array$data
     * @return array
     */
    private static function filterData($data)
    {
        foreach ($data as $key => $value) {
            if(!in_array($key, static::$atributosPermitidos)) {
                // Eliminamos la propiedad inválida.
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * Genera el query para el insert, según la $data
     * proporcionada.
     *
     * @param array $data
     * @return string
     */
    private static function generateInsertQuery($data)
    {
        // Definimos la parte estática de la consulta.
        $query = "INSERT INTO " . static::$tabla . " (";
        $queryValues = "VALUES (";

        // Creamos un par de variable para guardar
        // los campos y los holders que necesitamos.
        $fields = [];
        $holders = [];

        foreach ($data as $key => $value) {
            $fields[] = $key;
            $holders[] = ":" . $key;
        }

        // Finalmente, armamos la consulta y la
        // retornamos.
        $query .= implode(", ", $fields) . ")";
        $queryValues .= implode(", ", $holders) . ")";
        return $query . " " . $queryValues;
    }


    private function cargarAtributos()
    {
        $query = "SELECT COLUMN_NAME, COLUMN_KEY FROM `information_schema`.`COLUMNS` WHERE TABLE_SCHEMA = 'proximafecha' AND TABLE_NAME  = ? ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute([static::$tabla]);
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $atributo = $fila['COLUMN_NAME'];
            static::$atributosPermitidos[] = $atributo;
            $this->campos[$atributo] = "";
            if ($fila['COLUMN_KEY'] == 'PRI'){
                static::$clavesPermitidas[] = $atributo;
            }
        }
    }

    private function cargarClaves($keys)
    {
        if(!is_array($keys)) {
            throw new ParametroInvalidoException("El parámetros no es un array");
        };

        if (sizeof(static::$clavesPermitidas) == 0){
            static::cargarAtributos();
        }

        if(sizeof($keys) < sizeof(static::$clavesPermitidas)) {
            throw new ParametroInvalidoException("Faltan Claves en el Array");
        };
        foreach ($keys as $key => $value) {
            if(in_array($key, static::$clavesPermitidas)) {
                $this->claves[$key] = $value;
            }
        }
    }

    public static function imprimir($aImprimir)
    {
        echo "<pre>";
        print_r($aImprimir);
        echo "</pre>";
    }


    public static function imprimirClaves()
    {
        static::imprimir(static::$clavesPermitidas);
    }


    public static function ExistenClaves($claves)
    {
        $aux = new ClasePadre(static::$tabla);
        $aux->cargarClaves($claves);
        $query = $aux ->getSelectByKeys();
        $stmt = DBConnection::getStatement($query);

        if($stmt->execute($aux->claves)){
            return ($stmt->rowCount() > 0 );
        } else {
            throw New StatementInvalidoException($stmt->errorInfo());
        }

    }



    public function holaGonza()
    {
        return "hola gonza";
    }
}
