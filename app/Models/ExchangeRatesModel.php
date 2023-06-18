<?php

namespace App\Models;

use App\Helpers\DB;
use PDOStatement;

class ExchangeRatesModel extends Model
{
    protected static string $table = 'exchange_rates';
    protected static array $fillable = [
        'table_name', 'number', 'effective_date', 'currency', 'code', ' mid'
    ];

    /**
     * Create the exchange_rates table.
     *
     * @return PDOStatement|bool Returns the PDOStatement object on success or false on failure.
     */
    public static function create(): PDOStatement|bool
    {
        $query = sprintf('CREATE TABLE %s (
            id INT AUTO_INCREMENT PRIMARY KEY,
            table_name VARCHAR(50),
            number VARCHAR(50),
            effective_date DATE,
            currency VARCHAR(100),
            code VARCHAR(10),
            mid DECIMAL(10, 4)
        )', static::$table);

        return DB::query($query);
    }
}
