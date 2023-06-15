<?php

namespace App\Helpers;

use mysqli;
use mysqli_result;

class DB
{
    /**
     * @var mysqli|null
     */
    private static ?mysqli $conn = null;

    /**
     * Establishes a connection to the database.
     *
     * @return void
     */
    public static function connect(): void {
        $host = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_DATABASE'];
        $port = $_ENV['DB_PORT'];

        self::$conn = new mysqli($host, $username, $password, $dbname, $port);

        if (self::$conn->connect_error)
            die("Connection failed: " . self::$conn->connect_error);
    }

    /**
     * Closes the database connection.
     *
     * @return void
     */
    public static function disconnect(): void {
        if (self::$conn) {
            self::$conn->close();
            self::$conn = null;
        }
    }

    /**
     * Executes a database query.
     *
     * @param string $sql The SQL query to execute.
     * @return mysqli_result|bool The result object or `false` on failure.
     */
    public static function query(string $sql): mysqli_result|bool {
        if (!self::$conn)
            self::connect();
        return self::$conn->query($sql);
    }
}
