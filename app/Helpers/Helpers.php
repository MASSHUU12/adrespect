<?php

namespace App\Helpers;

class Helpers
{
    /**
     * Generates an HTML table from the provided data and headers.
     *
     * @param array $data An array containing the data for the table rows.
     * @param array $headers An array containing the headers for the table columns.
     * @return string The generated HTML table.
     */
    public static function generate_table(array $data, array $headers): string
    {
        $output = '
            <table>
                <tr>
        ';

        // Generate headers
        foreach ($headers as $header) {
            $output .= "<th>$header</th>";
        }

        $output .= '</tr>';

        // Add data
        foreach ($data as $row) {
            $output .= '<tr>';

            foreach ($row as $cell) {
                $output .= "<td>$cell</td>";
            }

            $output .= '</tr>';
        }

        $output .= '</table>';

        return $output;
    }

    /**
     * Generates an HTML ordered list from the given array of elements.
     *
     * @param array $elements An array of elements to be included in the ordered list.
     * @return string The generated ordered list as a string.
     */
    public static function generate_list(array $elements): string
    {
        $output = '<ol>';

        foreach ($elements as $element) {
            $output .= "<li>$element</li>";
        }

        $output .= '</ol>';

        return $output;
    }

    /**
     * Cleans a string by replacing spaces with underscores and removing special characters.
     *
     * @param string $string The string to be cleaned.
     * @return string The cleaned string.
     */
    public static function clean_string(string $string): string
    {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-_]/', '', $string); // Removes special chars.
    }

    /**
     * Checks if a currency code is valid according to the ISO 4217 standard.
     *
     * @param string $code The currency code to validate.
     * @return bool Returns true if the currency code is valid, false otherwise.
     */
    public static function is_currency_code_valid(string $code): bool
    {
        $pattern = '/^[A-Z]{3}$/'; // Regular expression pattern for ISO 4217 currency codes

        return preg_match($pattern, $code) === 1;
    }
}
