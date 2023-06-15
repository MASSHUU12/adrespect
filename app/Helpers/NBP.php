<?php

namespace App\Helpers;

use Exception;

class NBP
{
    private static string $url = 'http://api.nbp.pl/api/';

    /**
     * Fetches the latest exchange rates from the NBP API.
     *
     * @return array|bool An array containing exchange rate data or false if there was an error.
     */
    public static function get_exchange_rates(): array|bool
    {
        try {
            return API::call(self::$url . 'exchangerates/tables/A/last/1/');
        } catch (Exception $exception) {
            Log::error($exception);
            return false;
        }
    }

    /**
     * Saves the exchange rates to the database.
     *
     * @param array $response The response array containing exchange rate data.
     * @return bool True if the exchange rates were successfully saved, false otherwise.
     */
    public static function save_exchange_rates(array $response): bool
    {
        $table = $response[0]['table'];
        $no = $response[0]['no'];
        $effective_date = $response[0]['effectiveDate'];

        $rates = $response[0]['rates'];

        foreach ($rates as $rate) {
            $currency = $rate['currency'];
            $code = $rate['code'];
            $mid = $rate['mid'];

            try {
                DB::query("
                INSERT INTO `exchange_rates` (
                    `id`, `table_name`, `number`, `effective_date`, `currency`, `code`, `mid`
                ) VALUES (
                    NULL, '$table', '$no', '$effective_date', '$currency', '$code', '$mid'
                )");
            } catch (Exception $exception) {
                Log::error($exception);
                return false;
            }
        }
        DB::disconnect();

        Log::error('Exchange rates successfully uploaded to the database.', false);

        return true;
    }

    /**
     * Generates an HTML table from the exchange rates stored in the database.
     *
     * @return string|bool The generated HTML table or false if there are no exchange rates in the database.
     * @throws Exception If there is an error during the database operation.
     */
    public static function generate_exchange_rates_table(): string|bool
    {
        if (!DB::connect())
            return false;

        $db_result = DB::query('SELECT * FROM exchange_rates LIMIT 250;')->fetch_all();

        if (count($db_result) < 1)
            return false;

        return Helpers::generate_table($db_result, ['ID', 'Table Name', 'Number', 'Effective Date', 'Currency', 'Code', 'Mid']);
    }
}
