<?php


use PHPUnit\Framework\TestCase;

class ExampleAssertionsTest extends TestCase
{
    /**
     * 
     */
    public function testThatStringsMatch()
    {
        $string1 = "testing";
        $string2 = "testing";
        $string3 = "Testing";

        $this->assertSame($string1, $string2);
        $this->assertSame($string1, $string3);
    }
}
