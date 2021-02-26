<?php

namespace OpenAPIServer\Api;

use PHPUnit\Framework\TestCase;

class TimeParserTest extends TestCase
{
    public function testValidUTC()
    {
        $isoString = "2020-01-05T18:45:30.456Z";
        $expected = new \DateTime($isoString);
        $parsed = \OpenAPIServer\Parsers\TimeParser::parseTime($isoString);

        $this->assertEquals($expected, $parsed);
    }

    public function testValidWithOffset()
    {
        $isoString = "2020-01-05T18:45:30.456+0100";
        $expected = new \DateTime($isoString);
        $parsed = \OpenAPIServer\Parsers\TimeParser::parseTime($isoString);

        $this->assertEquals($expected, $parsed);
    }

    public function testThrowOnInvalid()
    {
        $invalid = "notATime";
        $this->expectException(\InvalidArgumentException::class);
        \OpenAPIServer\Parsers\TimeParser::parseTime($invalid);
    }
}
