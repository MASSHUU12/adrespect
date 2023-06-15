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
}
