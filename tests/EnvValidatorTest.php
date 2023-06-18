<?php

namespace Tests;

use App\Helpers\EnvValidator;
use PHPUnit\Framework\TestCase;

class EnvValidatorTest extends TestCase
{
    public function testValidateWithValidEnvironmentVariables()
    {
        $_ENV['APP_ENV'] = 'local';
        $_ENV['DB_HOST'] = 'localhost';
        $_ENV['DB_PORT'] = '3306';
        $_ENV['DB_DATABASE'] = 'my_database';
        $_ENV['DB_USERNAME'] = 'my_username';

        $errors = EnvValidator::validate();

        // Assert that no errors are returned
        $this->assertEquals([], $errors);
    }

    public function testValidationWithMissingEnvironmentVariables()
    {
        // Set up missing environment variables
        unset($_ENV['APP_ENV']);
        unset($_ENV['DB_HOST']);
        unset($_ENV['DB_PORT']);
        unset($_ENV['DB_DATABASE']);
        unset($_ENV['DB_USERNAME']);

        $errors = EnvValidator::validate();

        // Assert that errors are returned for missing variables
        $this->assertCount(5, $errors);

        $this->assertContains('APP_ENV was not found.', $errors);
        $this->assertContains('DB_HOST was not found.', $errors);
        $this->assertContains('DB_PORT was not found.', $errors);
        $this->assertContains('DB_DATABASE was not found.', $errors);
        $this->assertContains('DB_USERNAME was not found.', $errors);
    }

    public function testValidationWithInvalidEnvironmentVariables()
    {
        // Set up invalid environment variables
        $_ENV['APP_ENV'] = 'test';
        $_ENV['DB_HOST'] = '127.0.0.1';
        $_ENV['DB_PORT'] = 'abc';
        $_ENV['DB_DATABASE'] = 'my$database';
        $_ENV['DB_USERNAME'] = 'my\'username';

        $errors = EnvValidator::validate();

        // Assert that errors are returned for invalid variables
        $this->assertCount(4, $errors);

        $this->assertContains('Expected local, production in APP_ENV, found test.', $errors);
        $this->assertContains('Expected integer in DB_PORT, found abc.', $errors);
        $this->assertContains('Expected string without special characters in DB_DATABASE, found my$database.', $errors);
        $this->assertContains('Expected string without special characters in DB_USERNAME, found my\'username.', $errors);
    }
}
