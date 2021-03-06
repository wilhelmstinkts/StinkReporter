<?php

namespace OpenAPIServer\Api;

use PHPUnit\Framework\TestCase;
use OpenAPIServer\Services;
use OpenAPIServer\DTOs;

class WeatherServiceTest extends TestCase
{
    public function testParseApiResponseWithoutGust()
    {
        $apiResponse = '{"coord":{"lon":13.37,"lat":52.59},"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"base":"stations","main":{"temp":290.55,"feels_like":291.17,"temp_min":289.82,"temp_max":292.04,"pressure":1008,"humidity":93},"visibility":10000,"wind":{"speed":2.1,"deg":50},"rain":{"1h":2.29},"clouds":{"all":75},"dt":1598809682,"sys":{"type":1,"id":1275,"country":"DE","sunrise":1598760878,"sunset":1598810396},"timezone":7200,"id":2844910,"name":"Rosenthal","cod":200}';
        $parsed = \OpenAPIServer\Services\WeatherService::parseCurrentApiResponse($apiResponse);
        $this->assertEquals(290.55, $parsed->temperature);
        $this->assertEquals(50, $parsed->wind->direction);
        $this->assertEquals(2.1, $parsed->wind->speed);
        $this->assertNull($parsed->wind->gustSpeed);
    }

    public function testParseApiResponseWithGust()
    {
        $apiResponse = '{"coord":{"lon":13.37,"lat":52.59},"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10d"}],"base":"stations","main":{"temp":290.55,"feels_like":291.17,"temp_min":289.82,"temp_max":292.04,"pressure":1008,"humidity":93},"visibility":10000,"wind":{"speed":2.1,"deg":50,"gust":7.6},"rain":{"1h":2.29},"clouds":{"all":75},"dt":1598809682,"sys":{"type":1,"id":1275,"country":"DE","sunrise":1598760878,"sunset":1598810396},"timezone":7200,"id":2844910,"name":"Rosenthal","cod":200}';
        $parsed = \OpenAPIServer\Services\WeatherService::parseCurrentApiResponse($apiResponse);
        $this->assertEquals(290.55, $parsed->temperature);
        $this->assertEquals(50, $parsed->wind->direction);
        $this->assertEquals(2.1, $parsed->wind->speed);
        $this->assertEquals(7.6, $parsed->wind->gustSpeed);
    }

    public function testBuildRequestUri()
    {
        $weatherService = new \OpenAPIServer\Services\WeatherService("http://base.com", "key123");
        $time = new \DateTime('1970-01-01T00:00:01Z');
        $coordinates = new \OpenAPIServer\DTOs\Coordinates(1, 1);

        $expectedRequest = "http://base.com/onecall/timemachine?lat=1&lon=1&dt=1&APPID=key123";

        $this->assertEquals($expectedRequest, $weatherService->buildHistoricRequestUri($coordinates, $time));
    }
}
