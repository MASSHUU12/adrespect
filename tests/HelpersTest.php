<?php

namespace Tests;

use App\Helpers\Helpers;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function testCleanStringWithSpaces()
    {
        $input = "Hello World";
        $expectedOutput = "Hello_World";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testCleanStringWithSpecialCharacters()
    {
        $input = "Hello$#World!";
        $expectedOutput = "HelloWorld";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testCleanStringWithMixedCharacters()
    {
        $input = "Hello_World!123";
        $expectedOutput = "Hello_World123";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testCleanStringWithEmptyString()
    {
        $input = "";
        $expectedOutput = "";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testGenerateListWithEmptyArray()
    {
        $this->assertEquals('<ol></ol>', Helpers::generate_list([]));
    }

    public function testGenerateListWithSingleElement()
    {
        $this->assertEquals('<ol><li>Apple</li></ol>', Helpers::generate_list(['Apple']));
    }

    public function testGenerateListWithMultipleElements()
    {
        $elements = ['Apple', 'Banana', 'Cherry'];
        $expectedOutput = '<ol><li>Apple</li><li>Banana</li><li>Cherry</li></ol>';
        $actualOutput = Helpers::generate_list($elements);

        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testValidCurrencyCode()
    {
        $validCodes = ['USD', 'EUR', 'GBP', 'JPY'];

        foreach ($validCodes as $code) {
            $this->assertTrue(Helpers::is_currency_code_valid($code) === true);
        }
    }

    public function testInvalidCurrencyCode()
    {
        $invalidCodes = ['us', '$uro', 'gbp', '123'];

        foreach ($invalidCodes as $code) {
            $this->assertFalse(Helpers::is_currency_code_valid($code));
        }
    }
}
