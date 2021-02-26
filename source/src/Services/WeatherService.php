<?php

namespace OpenAPIServer\Services;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;
use OpenAPIServer\DTOs;
use OpenAPIServer\DTOs\Weather;
use OpenAPIServer\DTOs\Wind;

class WeatherService
{
    public string $baseUrl;
    public string $apiKey;
    public string $historicMock;

    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->historicMock = "";
    }

    public static function createMock(string $baseUrl, string $mock)
    {
        $service = new WeatherService($baseUrl, "mockKey");
        $service->historicMock = $mock;
        return $service;
    }

    public function getCurrentWeather(\OpenAPIServer\DTOs\Coordinates $coordinates): \OpenAPIServer\DTOs\Weather
    {
        $requestUri = "{$this->baseUrl}/weather?lat={$coordinates->latitude}&lon={$coordinates->longitude}&APPID={$this->apiKey}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "$requestUri");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $apiResponse = curl_exec($curl);
        curl_close($curl);

        return WeatherService::parseCurrentApiResponse($apiResponse);
    }

    public function getHistoricWeather(\OpenAPIServer\DTOs\Coordinates $coordinates, DateTime $time): \OpenAPIServer\DTOs\Weather
    {
        if ($this->historicMock != "") {
            $apiResponse = $this->historicMock;
        } else {
            $requestUri = $this->buildHistoricRequestUri($coordinates, $time);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "$requestUri");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $apiResponse = curl_exec($curl);
            curl_close($curl);
        }

        $responseArray = json_decode($apiResponse, true);
        $temperature = $responseArray["current"]["temp"];
        $windSpeed = $responseArray["current"]["wind_speed"];
        $windGust = $responseArray["current"]["wind_gust"];
        $windDirection = $responseArray["current"]["wind_deg"];

        return new Weather($temperature, new Wind($windDirection, $windSpeed, $windGust));
    }

    public function buildHistoricRequestUri(\OpenAPIServer\DTOs\Coordinates $coordinates, DateTime $time): string
    {
        return "{$this->baseUrl}/onecall/timemachine?lat={$coordinates->latitude}&lon={$coordinates->longitude}&dt={$time->getTimeStamp()}&APPID={$this->apiKey}";
    }

    public static function parseCurrentApiResponse(string $apiResponse): \OpenAPIServer\DTOs\Weather
    {
        $responseArray = json_decode($apiResponse, true);
        $wind = WeatherService::parseWind($responseArray);
        $temperature = WeatherService::parseTemperature($responseArray);
        return new  \OpenAPIServer\DTOs\Weather($temperature, $wind);
    }

    private static function parseWind(array $responseArray): \OpenAPIServer\DTOs\Wind
    {
        $wind = $responseArray["wind"];
        if (array_key_exists("gust", $wind)) {
            return new \OpenAPIServer\DTOs\Wind($wind["deg"], $wind["speed"], $wind["gust"]);
        }
        return new \OpenAPIServer\DTOs\Wind($wind["deg"], $wind["speed"], null);
    }

    private static function parseTemperature(array $responseArray): float
    {
        return $responseArray["main"]["temp"];
    }
}
