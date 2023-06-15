<?php

namespace Tests;

use App\Helpers\Log;
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase
{
    public function testErrorLogsErrorMessage()
    {
        $message = 'Test error message';
        $expected_log = "<p>$message</p>";

        ob_start();
        Log::error($message, show_caller: false);
        $actual_log = ob_get_clean();

        $this->assertEquals($expected_log, $actual_log);
    }

    public function testErrorIncludesCallerInfoWhenEnabled()
    {
        $message = 'Test error message';
        $file = __FILE__;
        $line = 30;
        $expected_log = "<p>[$file: $line] $message</p>";

        ob_start();
        Log::error($message);
        $actual_log = ob_get_clean();

        $this->assertStringContainsString($expected_log, $actual_log);
    }

    public function testErrorMethodAppliesStyleWhenColored()
    {
        $message = 'Test error message';
        $expected_log = "<p style='background-color: red; color: whitesmoke; padding: 0.3rem;'>$message</p>";

        ob_start();
        Log::error($message, false, true);
        $actual_log = ob_get_clean();

        $this->assertEquals($expected_log, $actual_log);
    }

    public function testIsDebugEnabledReturnsTrueInLocalEnvironment()
    {
        $is_debug_enabled = Log::is_debug_enabled();

        $this->assertTrue($is_debug_enabled);
    }

    public function testIsDebugEnabledReturnsFalseInNonLocalEnvironment()
    {
        $_ENV['APP_ENV'] = 'production';

        $is_debug_enabled = Log::is_debug_enabled();

        $this->assertFalse($is_debug_enabled);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $_ENV['APP_ENV'] = 'local';
    }
}
