<?php

namespace App\Models;

use App\Helpers\DB;
use PDOStatement;

class Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected static string $table = "";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected static array $fillable = [];

    /**
     * Create a new record in the database.
     *
     * @param array $values The attribute values to be inserted.
     * @return PDOStatement|bool Returns PDOStatement on success or false on failure.
     */
    public static function create(array $values): PDOStatement|bool
    {
        $query = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            self::get_columns(),
            self::create_placeholders($values)
        );

        return DB::query($query, array_values($values));
    }

    /**
     * Get the column names as a comma-separated string.
     *
     * @return string Returns the column names.
     */
    protected static function get_columns(): string
    {
        // Using late static binding to get access to the override variables
        return implode(',', static::$fillable);
    }

    /**
     * Create placeholders for the given values as a comma-separated string.
     *
     * @param array $values The attribute values.
     * @return string Returns the placeholders.
     */
    protected static function create_placeholders(array $values): string
    {
        // Using late static binding to get access to the override variables
        return implode(',', array_fill(0, count($values), '?'));
    }

    /**
     * Execute a database query with optional parameters.
     *
     * @param string $sql The SQL query string.
     * @param array $params [optional] The parameters to bind to the query.
     * @return PDOStatement|bool Returns PDOStatement on success or false on failure.
     */
    public static function query(string $sql, array $params = []): PDOStatement|bool
    {
        $statement = DB::query($sql, $params);

        if (!$statement) {
            return false;
        }
        return $statement;
    }

    /**
     * Retrieve all records from the associated table.
     *
     * @return PDOStatement|bool Returns PDOStatement on success or false on failure.
     */
    public static function get(): PDOStatement|bool
    {
        $query = sprintf("SELECT * FROM %s", static::$table);
        $statement = DB::query($query);

        if (!$statement) {
            return false;
        }
        return $statement;
    }

    /**
     * Disconnect from the database.
     *
     * @return void
     */
    public static function disconnect(): void
    {
        DB::disconnect();
    }
}