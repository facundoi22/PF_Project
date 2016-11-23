<?php
require_once 'DBConnection.php';


/**
 * Implementación de la clase Noticia
 */
class Noticia
{

    /**
     * Trae detalles de la ultima noticia activa
     * @return array|string
     */
    public static function getNoticiaActiva()
    {
        $rta="";
        $script = "SELECT noticia_id, titulo, noticia FROM noticias_home WHERE activa = 1";
        $stmt = DBConnection::getStatement($script );
        if ($stmt->execute() ) {
            $rta = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $rta;
    }

    /**
     * Borra todas las noticias de la base.
     */
    public static function borrarNoticias()
    {
        $script = "DELETE FROM noticias_home ";
        $stmt = DBConnection::getStatement($script );
        $stmt->execute() ;
    }


    /**
     * Inserta una nueva noticia en la base de datos en base a los parámetros recibidos;
     * @param $titulo
     * @param $noticia
     */
    public static function crearNoticia($titulo, $noticia)
    {
        $script = "INSERT INTO noticias_home (noticia_id, titulo, noticia, activa) VALUES ( NULL, :titulo, :noticia, 1) " ;
        $stmt = DBConnection::getStatement($script );
        $stmt->execute(['titulo'=> $titulo, 'noticia'=> $noticia]) ;
    }
}