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
     * Truncates the table associated with the model.
     *
     * @return PDOStatement|bool Returns a PDOStatement object on success or `false` on failure.
     */
    public static function truncate(): PDOStatement|bool
    {
        $query = sprintf('TRUNCATE TABLE %s', static::$table);

        return DB::query($query);
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
        return DB::query($sql, $params);
    }

    /**
     * Drops the table associated with the model.
     *
     * @return PDOStatement|bool Returns a PDOStatement object on success or `false` on failure.
     */
    public static function drop(): PDOStatement|bool
    {
        $query = sprintf('DROP TABLE %s', static::$table);

        return DB::query($query);
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

    /**
     * Insert a new record into the database.
     *
     * @param array $values The attribute values to be inserted.
     * @return PDOStatement|bool Returns PDOStatement on success or false on failure.
     */
    public static function insert(array $values): PDOStatement|bool
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
     * Retrieve records from the associated table.
     *
     * @param int|null $limit The maximum number of records to retrieve. If null, retrieves all records.
     * @param array $order_by An array specifying the columns to order the records by.
     * @param bool $ascending Specifies whether the records should be sorted in ascending order. Default is true.
     * @return PDOStatement|bool Returns a PDOStatement object on success or false on failure.
     */
    public static function get(?int $limit, array $order_by = [], bool $ascending = true): PDOStatement|bool
    {
        $query_limit = !is_null($limit) ? "LIMIT $limit " : '';
        $query_direction = $ascending ? 'ASC' : 'DESC';
        $query_order = !empty($order_by) ? 'ORDER BY ' . implode(',', $order_by) . " $query_direction " : '';

        $query = 'SELECT * FROM ' .
            static::$table . ' ' .
            $query_order .
            $query_limit .
            ';';

        return DB::query($query);
    }
}
