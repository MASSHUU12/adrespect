<?php

namespace App\Models;

class ExchangeRatesModel extends Model
{
    protected static string $table = 'exchange_rates';
    protected static array $fillable = [
        'table_name', 'number', 'effective_date', 'currency', 'code', ' mid'
    ];
}
