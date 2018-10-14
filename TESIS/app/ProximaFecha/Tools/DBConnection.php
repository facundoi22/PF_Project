<?php
/*
 * Clase wrapper de PDO en modo Singleton.
 */
namespace ProximaFecha\Tools;

use PDO;
use PDOStatement;

class DBConnection implements DBConnectionInterface
{
    /** @var PDO    Instancia en modo Singleton de PDO */
    protected static $db;

    /**
     * DBConnection constructor. Se define privado
     * para que nadie pueda instanciar la clase.
     */
    private function __construct()
    {}

    /**
     * Conecta con la base de datos.
     */
    private static function connect()
    {
        $db_host = "localhost";
/*        $db_user = "p4000541_PFECHA";
        $db_pass = "mikaDA72zu";
        $db_name = "p4000541_PFECHA";*/

        $db_user = "root";
        $db_pass = "";
        $db_name = "DW4_PROXIMAFECHA";
        $db_dsn = "mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8";
        self::$db = new PDO($db_dsn, $db_user, $db_pass);
    }

    /**
     * Retorna el objeto PDO de la conexión.
     *
     * @return PDO
     */
    public static function getConnection()
    {
        if(is_null(self::$db)) {
            self::connect();
        }

        return self::$db;
    }

    /**
     * @param string $query
     * @return PDOStatement
     */
    public static function getStatement($query)
    {
        return self::getConnection()->prepare($query);
    }
}

