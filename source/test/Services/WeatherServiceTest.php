<?php

namespace OpenAPIServer\Api;

use PHPUnit\Framework\TestCase;
use OpenAPIServer\Services;
use OpenAPIServer\DTOs;

class WeatherServiceTest extends TestCase
{
    private const CURRENT_RESPONSE = '{"latitude":52.58,"longitude":13.36,"timezone":"GMT","current_units":'
        . '{"temperature_2m":"°C","wind_speed_10m":"m/s","wind_direction_10m":"°","wind_gusts_10m":"m/s"},'
        . '"current":{"time":"2026-09-07T19:30","temperature_2m":18.3,"wind_speed_10m":2.53,'
        . '"wind_direction_10m":162,"wind_gusts_10m":6.0}}';

    private const HOURLY_RESPONSE = '{"latitude":52.58,"longitude":13.36,"timezone":"GMT","hourly":{'
        . '"time":["2026-09-04T12:00","2026-09-04T13:00","2026-09-04T14:00"],'
        . '"temperature_2m":[24.3,24.2,24.0],'
        . '"wind_speed_10m":[3.1,3.4,3.6],'
        . '"wind_direction_10m":[200,210,220],'
        . '"wind_gusts_10m":[7.2,7.8,8.1]}}';

    public function testParseCurrentApiResponse()
    {
        $parsed = \OpenAPIServer\Services\WeatherService::parseCurrentApiResponse(self::CURRENT_RESPONSE);

        // Open-Meteo reports Celsius, reports are stored in Kelvin
        $this->assertEqualsWithDelta(291.45, $parsed->temperature, 0.001);
        $this->assertEquals(162, $parsed->wind->direction);
        $this->assertEquals(2.53, $parsed->wind->speed);
        $this->assertEquals(6.0, $parsed->wind->gustSpeed);
    }

    public function testParseCurrentApiResponseWithoutReadingsThrows()
    {
        $this->expectException(\Exception::class);
        \OpenAPIServer\Services\WeatherService::parseCurrentApiResponse('{"error":true,"reason":"nope"}');
    }

    public function testParseHistoricApiResponsePicksTheNearestHour()
    {
        $time = new \DateTime('2026-09-04T13:20:00Z');
        $parsed = \OpenAPIServer\Services\WeatherService::parseHistoricApiResponse(self::HOURLY_RESPONSE, $time);

        // 13:20 is closest to the 13:00 reading
        $this->assertEqualsWithDelta(297.35, $parsed->temperature, 0.001);
        $this->assertEquals(210, $parsed->wind->direction);
        $this->assertEquals(3.4, $parsed->wind->speed);
        $this->assertEquals(7.8, $parsed->wind->gustSpeed);
    }

    public function testParseHistoricApiResponseRoundsToTheLaterHour()
    {
        $time = new \DateTime('2026-09-04T13:45:00Z');
        $parsed = \OpenAPIServer\Services\WeatherService::parseHistoricApiResponse(self::HOURLY_RESPONSE, $time);

        $this->assertEquals(220, $parsed->wind->direction);
    }

    public function testBuildCurrentRequestUri()
    {
        $weatherService = new \OpenAPIServer\Services\WeatherService("http://base.com");
        $coordinates = new \OpenAPIServer\DTOs\Coordinates(13.5, 52.5);

        $this->assertEquals(
            "http://base.com/forecast?latitude=52.5&longitude=13.5"
                . "&current=temperature_2m,wind_speed_10m,wind_direction_10m,wind_gusts_10m"
                . "&wind_speed_unit=ms&timezone=UTC",
            $weatherService->buildCurrentRequestUri($coordinates)
        );
    }

    public function testBuildHistoricRequestUriUsesTheDayInUtc()
    {
        $weatherService = new \OpenAPIServer\Services\WeatherService("http://base.com");
        $coordinates = new \OpenAPIServer\DTOs\Coordinates(13.5, 52.5);
        // 00:30 in Berlin is still the previous day in UTC
        $time = new \DateTime('2021-01-26T00:30:00+02:00');

        $this->assertEquals(
            "http://base.com/forecast?latitude=52.5&longitude=13.5"
                . "&hourly=temperature_2m,wind_speed_10m,wind_direction_10m,wind_gusts_10m"
                . "&wind_speed_unit=ms&timezone=UTC"
                . "&start_date=2021-01-25&end_date=2021-01-25",
            $weatherService->buildHistoricRequestUri($coordinates, $time)
        );
    }
}
