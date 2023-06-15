<?php

namespace App\Helpers;

use InvalidArgumentException;
use RuntimeException;

class API
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    public static function call(string $url, string $method = self::GET, $data = null, array $headers = []): mixed
    {
        self::validate($url, $method);

        $curl = curl_init($url);

        // Set the request method
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        // Set the request data if provided
        if (!is_null($data)) {
            $encoded_data = json_encode($data);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $encoded_data);
            $headers[] = 'Content-Type: application/json';
        }

        // Set the request headers & other options
        $headers[] = 'Accept: application/json';
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

        // Send the request and get the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            Log::error($error);

            throw new RuntimeException('Request failed.');
        }

        // Get the response code
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close the cURL resource
        curl_close($curl);

        // Process the response
        if ($status_code >= 200 && $status_code < 300)
            return json_decode($response, true);
        else
            throw new RuntimeException('HTTP request failed with status code: ' . $status_code);
    }

    private static function validate(string $url, string $method): void
    {
        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL))
            throw new InvalidArgumentException('Invalid URL provided.');

        // Validate HTTP method
        $valid_methods = [self::GET, self::POST, self::PUT, self::DELETE];
        if (!in_array($method, $valid_methods))
            throw new InvalidArgumentException('Invalid HTTP method provided.');
    }
}
