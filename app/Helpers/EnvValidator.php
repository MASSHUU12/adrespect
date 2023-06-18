<?php

namespace App\Helpers;

use JetBrains\PhpStorm\Pure;

class EnvValidator
{
    /**
     * @var array|array[]
     */
    private static array $variables = [
        'APP_ENV' => [
            'rules' => [],
            'other_acceptable_values' => ['local', 'production'],
            'looking_for' => ['local', 'production']
        ],
        'DB_HOST' => [
            'rules' => [FILTER_VALIDATE_IP],
            'other_acceptable_values' => ['localhost'],
            'looking_for' => ['IP', 'localhost']
        ],
        'DB_PORT' => [
            'rules' => [FILTER_VALIDATE_INT],
            'other_acceptable_values' => [],
            'looking_for' => ['integer']
        ],
        'DB_DATABASE' => [
            'rules' => ['clean_string'],
            'other_acceptable_values' => [],
            'looking_for' => ['string without special characters']
        ],
        'DB_USERNAME' => [
            'rules' => ['clean_string'],
            'other_acceptable_values' => [],
            'looking_for' => ['string without special characters']
        ]
    ];

    /**
     * Validate the environment variables.
     *
     * @return array|array[] An array of validation errors.
     */
    public static function validate(): array
    {
        $errors = self::check_if_exists();
        $results = [];

        if (count($errors) > 0) {
            return $errors;
        }

        foreach (self::$variables as $env_elem => $rules) {
            $current_value = $_ENV[$env_elem] ?? null;
            $is_valid = true;

            // Check rules
            foreach ($rules['rules'] as $rule) {
                if ($rule === 'clean_string' &&
                    (Helpers::clean_string($current_value) !== $current_value || empty($current_value))) {
                    $is_valid = false;
                    break;
                } elseif ($rule === 'clean_string') {
                    continue;
                }

                $filter = is_string($rule) ? constant($rule) : $rule;

                if (!filter_var($current_value, $filter)) {
                    $is_valid = false;
                    break;
                }
            }

            if (in_array($current_value, $rules['other_acceptable_values'])) {
                continue;
            }

            // Check acceptable values if rules fail
            if (!$is_valid ||
                (!in_array($current_value, $rules['other_acceptable_values']) && empty($rules['rules']))) {
                $results[] = self::create_message(
                    $env_elem,
                    $current_value,
                    implode(', ', $rules['looking_for'])
                );
            }
        }

        return $results;
    }

    /**
     * Check if required environment variables exist.
     *
     * @return array An array of missing variable messages.
     */
    #[Pure(true)] private static function check_if_exists(): array
    {
        $results = [];

        foreach (array_keys(self::$variables) as $variable) {
            if (!isset($_ENV[$variable])) {
                $results[] = self::create_not_found_message($variable);
            }
        }

        return $results;
    }

    /**
     * Create a message for a missing environment variable.
     *
     * @param string $env_elem The name of the missing environment variable.
     * @return string The error message.
     */
    private static function create_not_found_message(string $env_elem): string
    {
        return "$env_elem was not found.";
    }

    /**
     * Create an error message for a validation rule violation.
     *
     * @param string $env_elem The name of the environment variable.
     * @param string $current_value The current value of the environment variable.
     * @param string $expected_value The expected value or validation rule.
     * @return string The error message.
     */
    private static function create_message(string $env_elem, string $current_value, string $expected_value): string
    {
        return "Expected $expected_value in $env_elem, found $current_value.";
    }
}
