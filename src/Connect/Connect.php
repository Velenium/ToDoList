<?php

namespace App\Connect;

class Connect {

    private static $connect;
 
    public function connect()
    {
        $connectString = Config::getConnectionString();
        $options = Config::getOptions();
        $pdo = new \PDO($connectString, null, null, $options);
 
        return $pdo;
    }

    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }
 
        return static::$conn;
    }
}