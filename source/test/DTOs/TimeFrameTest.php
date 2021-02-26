<?php

namespace OpenAPIServer\Api;

use PHPUnit\Framework\TestCase;

class TimeFrameTest extends TestCase
{
    public function testAverageTime()
    {
        $startTime = new \DateTime("2020-01-05T18:45:30.000Z");
        $endTime = new \DateTime("2020-01-07T18:45:30.000Z");
        $timeFrame = new \OpenAPIServer\DTOs\TimeFrame($startTime, $endTime);
        $expectedAverage = new \DateTime("2020-01-06T18:45:30.000Z");
        $average = $timeFrame->averageTime();

        $this->assertEquals($expectedAverage, $average);
    }
}
