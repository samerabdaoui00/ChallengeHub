<?php

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            $host = "127.0.0.1;port=3308";
            $db_name = "challengehub";
            $username = "root";
            $password = ""; 

            try {
                self::$connection = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Connection error: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
