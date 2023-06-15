<?php

namespace App\Helpers;

use Exception;

class NBP
{
    private static string $url = 'http://api.nbp.pl/api/';

    public static function get_exchange_rates(): array|bool
    {
        try {
            return API::call(self::$url . 'exchangerates/tables/A/last/1/');
        } catch (Exception $exception) {
            Log::error($exception);
            return false;
        }
    }
}
