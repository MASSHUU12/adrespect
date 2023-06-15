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
}
