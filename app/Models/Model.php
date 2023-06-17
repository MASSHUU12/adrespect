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
     */
    public static function create(array $values): bool
    {
        // Using late static binding to get access to the override variables
        $columns = implode(',', static::$fillable);
        $placeholders = implode(',', array_fill(0, count($values), '?'));

        $query = sprintf("INSERT INTO %s (%s) VALUES (%s)", static::$table, $columns, $placeholders);

        try {
            DB::query($query, array_values($values));
        } catch (Exception $exception) {
            Log::error($exception);
            return false;
        }
        return true;
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
