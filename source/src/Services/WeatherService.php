<?php

namespace OpenAPIServer\Services;

use DateTime;
use DateTimeZone;
use Exception;
use OpenAPIServer\DTOs\Weather;
use OpenAPIServer\DTOs\Wind;

/**
 * Reads weather from Open-Meteo (https://open-meteo.com).
 *
 * Open-Meteo needs no API key, serves current and past readings from the same
 * endpoint, and is built on the DWD ICON model for Germany. It reports
 * temperatures in degrees Celsius, but reports have always been stored in
 * Kelvin, so the conversion happens here rather than changing the column and
 * every row already in it.
 */
class WeatherService
{
    private const DEFAULT_BASE_URL = "https://api.open-meteo.com/v1";
    private const MEASUREMENTS = "temperature_2m,wind_speed_10m,wind_direction_10m,wind_gusts_10m";
    private const KELVIN_OFFSET = 273.15;
    private const TIMEOUT_SECONDS = 10;

    public string $baseUrl;
    public string $historicMock;
    public string $currentMock;

    public function __construct(string $baseUrl = self::DEFAULT_BASE_URL)
    {
        $this->baseUrl = $baseUrl;
        $this->historicMock = "";
        $this->currentMock = "";
    }

    public static function createMock(string $historicMock, string $currentMock = ""): WeatherService
    {
        $service = new WeatherService();
        $service->historicMock = $historicMock;
        $service->currentMock = $currentMock;
        return $service;
    }

    public function getCurrentWeather(\OpenAPIServer\DTOs\Coordinates $coordinates): Weather
    {
        $apiResponse = $this->currentMock !== ""
            ? $this->currentMock
            : WeatherService::fetch($this->buildCurrentRequestUri($coordinates));

        return WeatherService::parseCurrentApiResponse($apiResponse);
    }

    public function getHistoricWeather(\OpenAPIServer\DTOs\Coordinates $coordinates, DateTime $time): Weather
    {
        $apiResponse = $this->historicMock !== ""
            ? $this->historicMock
            : WeatherService::fetch($this->buildHistoricRequestUri($coordinates, $time));

        return WeatherService::parseHistoricApiResponse($apiResponse, $time);
    }

    public function buildCurrentRequestUri(\OpenAPIServer\DTOs\Coordinates $coordinates): string
    {
        return "{$this->baseUrl}/forecast"
            . "?latitude={$coordinates->latitude}&longitude={$coordinates->longitude}"
            . "&current=" . self::MEASUREMENTS
            . "&wind_speed_unit=ms&timezone=UTC";
    }

    public function buildHistoricRequestUri(\OpenAPIServer\DTOs\Coordinates $coordinates, DateTime $time): string
    {
        $day = WeatherService::inUtc($time)->format("Y-m-d");
        return "{$this->baseUrl}/forecast"
            . "?latitude={$coordinates->latitude}&longitude={$coordinates->longitude}"
            . "&hourly=" . self::MEASUREMENTS
            . "&wind_speed_unit=ms&timezone=UTC"
            . "&start_date={$day}&end_date={$day}";
    }

    public static function parseCurrentApiResponse(string $apiResponse): Weather
    {
        $readings = json_decode($apiResponse, true)["current"] ?? null;
        if (!is_array($readings)) {
            throw new Exception("Weather service returned no current readings", 1);
        }
        return WeatherService::toWeather($readings);
    }

    /**
     * Open-Meteo returns a whole day of hourly readings; pick the hour closest
     * to the time being reported.
     */
    public static function parseHistoricApiResponse(string $apiResponse, DateTime $time): Weather
    {
        $hourly = json_decode($apiResponse, true)["hourly"] ?? null;
        if (!is_array($hourly) || !is_array($hourly["time"] ?? null) || count($hourly["time"]) === 0) {
            throw new Exception("Weather service returned no hourly readings", 1);
        }

        $index = WeatherService::indexOfNearestHour($hourly["time"], $time);
        return WeatherService::toWeather([
            "temperature_2m" => $hourly["temperature_2m"][$index] ?? null,
            "wind_direction_10m" => $hourly["wind_direction_10m"][$index] ?? null,
            "wind_speed_10m" => $hourly["wind_speed_10m"][$index] ?? null,
            "wind_gusts_10m" => $hourly["wind_gusts_10m"][$index] ?? null,
        ]);
    }

    private static function toWeather(array $readings): Weather
    {
        foreach (["temperature_2m", "wind_direction_10m", "wind_speed_10m"] as $required) {
            if (!isset($readings[$required])) {
                throw new Exception("Weather service returned no $required", 1);
            }
        }

        $gustSpeed = $readings["wind_gusts_10m"] ?? null;
        return new Weather(
            WeatherService::toKelvin((float) $readings["temperature_2m"]),
            new Wind(
                (float) $readings["wind_direction_10m"],
                (float) $readings["wind_speed_10m"],
                is_null($gustSpeed) ? null : (float) $gustSpeed
            )
        );
    }

    private static function indexOfNearestHour(array $timestamps, DateTime $time): int
    {
        $target = $time->getTimestamp();
        $nearest = 0;
        $smallestDistance = PHP_INT_MAX;
        foreach ($timestamps as $index => $timestamp) {
            $distance = abs((new DateTime($timestamp, new DateTimeZone("UTC")))->getTimestamp() - $target);
            if ($distance < $smallestDistance) {
                $smallestDistance = $distance;
                $nearest = $index;
            }
        }
        return $nearest;
    }

    private static function toKelvin(float $celsius): float
    {
        return $celsius + self::KELVIN_OFFSET;
    }

    private static function inUtc(DateTime $time): DateTime
    {
        return (clone $time)->setTimezone(new DateTimeZone("UTC"));
    }

    private static function fetch(string $requestUri): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::TIMEOUT_SECONDS);
        $apiResponse = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($apiResponse === false) {
            throw new Exception("Could not reach the weather service: $error", 1);
        }
        return $apiResponse;
    }
}
