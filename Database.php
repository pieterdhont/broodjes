<?php
// Database.php
declare(strict_types=1);

class Database {
    private static $connection = null;

    private function __construct() {}

    public static function getConnection(): PDO {
        if (!self::$connection) {
            self::$connection = new PDO("mysql:host=localhost;dbname=broodjesbar", "root", "");
        }
        return self::$connection;
    }
}
?>

