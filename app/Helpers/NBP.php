<?php

namespace App\Helpers;

class NBP
{
    private static string $url = 'http://api.nbp.pl/api/';

    public static function get_exchange_rates()
    {
        $response = API::call(self::$url . 'exchangerates/tables/A/last/1/');

        print_r($response);
    }
}
