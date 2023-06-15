<?php

namespace App\Helpers;

class Log
{
    /**
     * Logs an error message.
     *
     * @param string $message The error message.
     * @param bool $show_caller (Optional) Whether to include caller information. Default is true.
     * @param bool $colored (Optional) Whether to apply styling to the message. Default is false.
     * @return void
     */
    public static function error(string $message = '',
                                 bool   $show_caller = true,
                                 bool   $colored = false): void
    {
        if (!self::is_debug_enabled())
            return;

        $info = $show_caller ? self::get_caller_info() . ' ' : '';
        $style = $colored ? " style='background-color: red; color: whitesmoke; padding: 0.3rem;'" : '';

        echo "<p$style>$info $message</p>";
    }

    /**
     * Checks if debug mode is enabled.
     *
     * @return bool True if debug mode is enabled, false otherwise.
     */
    public static function is_debug_enabled(): bool
    {
        return $_ENV['APP_ENV'] == 'local';
    }

    /**
     * Retrieves information about the caller.
     *
     * @return string Information about the caller in the format '[file: line]'.
     */
    private static function get_caller_info(): string
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $backtrace[1];

        return '[' . $caller['file'] . ': ' . $caller['line'] . ']';
    }
}
