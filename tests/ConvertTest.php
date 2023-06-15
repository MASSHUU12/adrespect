<?php

namespace Tests;

use App\Helpers\Convert;
use PHPUnit\Framework\TestCase;

class ConvertTest extends TestCase
{

    public function testStrToInt()
    {
        $this->assertSame(123, Convert::str_to_int("123"));
        $this->assertSame(-456, Convert::str_to_int("-456"));
        $this->assertSame(0, Convert::str_to_int("0"));
        $this->assertSame(null, Convert::str_to_int("abc"));
        $this->assertSame(null, Convert::str_to_int(""));
    }

    public function testStrToFloat()
    {
        $this->assertSame(123.45, Convert::str_to_float("123.45"));
        $this->assertSame(-67.89, Convert::str_to_float("-67.89"));
        $this->assertSame(0.0, Convert::str_to_float("0.0"));
        $this->assertSame(null, Convert::str_to_float("abc"));
        $this->assertSame(null, Convert::str_to_float(""));
    }
}
