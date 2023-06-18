<?php

namespace Tests;

use App\Helpers\Helpers;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function testClean_stringWithSpaces()
    {
        $input = "Hello World";
        $expectedOutput = "Hello_World";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testClean_stringWithSpecialCharacters()
    {
        $input = "Hello$#World!";
        $expectedOutput = "HelloWorld";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testClean_stringWithMixedCharacters()
    {
        $input = "Hello_World!123";
        $expectedOutput = "Hello_World123";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testClean_stringWithEmptyString()
    {
        $input = "";
        $expectedOutput = "";
        $actualOutput = Helpers::clean_string($input);
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}
