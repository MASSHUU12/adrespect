<?php

namespace App\Models;

use App\Helpers\DB;
use App\Helpers\Log;
use Exception;

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
     * @return bool True if the record was successfully created, false otherwise.
     * @throws Exception If there is an error executing the database query.
     */
    public static function create(array $values): bool
    {
        $query = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            self::get_columns(),
            self::create_placeholders($values)
        );

        try {
            DB::query($query, array_values($values));
        } catch (Exception $exception) {
            Log::error($exception);
            return false;
        }
        return true;
    }

    /**
     * Get the column names as a comma-separated string.
     *
     * @return string The column names.
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
     * @return string The placeholders.
     */
    protected static function create_placeholders(array $values): string
    {
        // Using late static binding to get access to the override variables
        return implode(',', array_fill(0, count($values), '?'));
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
