<?php

namespace App\Models;

use App\Helpers\DB;
use PDOStatement;

class CurrencyConversionsModel extends Model
{
    protected static string $table = 'currency_conversions';

    protected static array $fillable = [
        'source_currency_code',
        'source_currency_amount',
        'target_currency_code',
        'target_currency_amount'
    ];

    /**
     * Create the currency_conversions table.
     *
     * @return PDOStatement|bool Returns the PDOStatement object on success or false on failure.
     */
    public static function create(): PDOStatement|bool
    {
        $query = sprintf('CREATE TABLE %s (
            id INT AUTO_INCREMENT PRIMARY KEY,
            source_currency_code VARCHAR(10),
            source_currency_amount DECIMAL(10, 4),
            target_currency_code VARCHAR(10),
            target_currency_amount DECIMAL(10, 4),
            conversion_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )', static::$table);

        return DB::query($query);
    }
}
