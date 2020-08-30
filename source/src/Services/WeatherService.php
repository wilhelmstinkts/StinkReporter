<?php

namespace OpenAPIServer\Services;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;
use OpenAPIServer\DTOs;

class WeatherService
{
    public string $baseUrl;
    public string $apiKey;

    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function getWind(\OpenAPIServer\DTOs\Coordinates $coordinates)
    {
        $requestUri = "{$this->baseUrl}?lat={$coordinates->latitude}&lon={$coordinates->longitude}&APPID={$this->apiKey}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "$requestUri");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $apiResponse = curl_exec($curl);
        curl_close($curl);

        return WeatherService::parseApiResponse($apiResponse);
    }

    public static function parseApiResponse(string $apiResponse)
    {
        $wind = json_decode($apiResponse, true)["wind"];
        if (array_key_exists("gust", $wind)) {
            return new \OpenAPIServer\DTOs\Wind($wind["deg"], $wind["speed"], $wind["gust"]);
        }
        return new \OpenAPIServer\DTOs\Wind($wind["deg"], $wind["speed"], null);
    }
}
