<?php

namespace App\Helpers;

use PDO;
use PDOStatement;

class DB
{
    /**
     * @var PDO|null
     */
    private static ?PDO $conn = null;

    /**
     * Closes the database connection.
     *
     * @return void
     */
    public static function disconnect(): void
    {
        self::$conn = null;
    }

    /**
     * Executes a database query.
     *
     * @param string $sql The SQL query to execute.
     * @return PDOStatement|bool The PDOStatement object or `false` on failure.
     */
    public static function query(string $sql, array $params = []): PDOStatement|bool
    {
        if (!self::$conn && !self::connect()) {
            return false;
        }

        $statement = self::$conn->prepare($sql);

        if (!$statement->execute($params)) {
            Log::error($statement->errorInfo()[2]);
            return false;
        }
        return $statement;
    }

    /**
     * Establishes a connection to the database.
     *
     * @return bool
     */
    public static function connect(): bool
    {
        $host = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_DATABASE'];
        $port = $_ENV['DB_PORT'];

        $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
        self::$conn = new PDO($dsn, $username, $password);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

        return true;
    }
}
