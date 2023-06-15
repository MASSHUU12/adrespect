<?php

namespace App\Helpers;

class Helpers
{
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
