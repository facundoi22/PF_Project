<?php
/*
 * Clase wrapper de PDO en modo Singleton.
 */



//class DBConnection
class DBConnection
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
//        echo "Abriendo la conexión a la BBDD...";
        $db_host = "localhost";
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
        // Verificamos si tenemos que conectarnos
        // primero.
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

