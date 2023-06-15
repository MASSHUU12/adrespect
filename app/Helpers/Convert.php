<?php

namespace App\Helpers;

class Convert
{
    /**
     * Converts a string to an integer.
     *
     * @param string $str The string to convert.
     * @return int|null The converted integer value, or null if the conversion fails.
     */
    public static function str_to_int(string $str): int|null
    {
        $value = filter_var($str, FILTER_VALIDATE_INT);
        return ($value !== false) ? intval($value) : null;
    }

    /**
     * Converts a string to a float.
     *
     * @param string $str The string to convert.
     * @return float|null The converted float value, or null if the conversion fails.
     */
    public static function str_to_float(string $str): float|null
    {
        $value = filter_var($str, FILTER_VALIDATE_FLOAT);
        return ($value !== false) ? floatval($value) : null;
    }

    /**
     * Converts an amount from one currency to another based on the exchange rates.
     *
     * @param float $amount The amount of money to be converted.
     * @param float $from_mid The exchange rate for the currency converting from.
     * @param float $to_mid The exchange rate for the currency converting to.
     *
     * @return float The converted amount.
     */
    public static function currency(float $amount, float $from_mid, float $to_mid): float
    {
        // Calculate the conversion rate
        $conversion_rate = $to_mid / $from_mid;

        // Convert the amount to the new currency
        return $amount * $conversion_rate;
    }
}
