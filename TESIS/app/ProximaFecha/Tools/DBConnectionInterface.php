<?php
namespace ProximaFecha\Tools;

interface DBConnectionInterface
{
    public static function getConnection();

    public static function getStatement($query);
}