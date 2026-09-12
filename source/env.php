<?php

// For test purposes only! Do not put production variables in here!
namespace Environment;

class Environment
{
    public static $useMockWeatherService = true;

    public static function mockWeatherService(): \OpenAPIServer\Services\WeatherService
    {
        // Recorded Open-Meteo responses, so tests never depend on the network.
        $historicMock = <<<EOD
        {
            "latitude": 52.58,
            "longitude": 13.359999,
            "generationtime_ms": 2.0003318786621094,
            "utc_offset_seconds": 0,
            "timezone": "GMT",
            "timezone_abbreviation": "GMT",
            "elevation": 49.0,
            "hourly_units": {
                "time": "iso8601",
                "temperature_2m": "\u00b0C",
                "wind_speed_10m": "m/s",
                "wind_direction_10m": "\u00b0",
                "wind_gusts_10m": "m/s"
            },
            "hourly": {
                "time": [
                    "2026-09-04T00:00",
                    "2026-09-04T01:00",
                    "2026-09-04T02:00",
                    "2026-09-04T03:00",
                    "2026-09-04T04:00",
                    "2026-09-04T05:00",
                    "2026-09-04T06:00",
                    "2026-09-04T07:00",
                    "2026-09-04T08:00",
                    "2026-09-04T09:00",
                    "2026-09-04T10:00",
                    "2026-09-04T11:00",
                    "2026-09-04T12:00",
                    "2026-09-04T13:00",
                    "2026-09-04T14:00",
                    "2026-09-04T15:00",
                    "2026-09-04T16:00",
                    "2026-09-04T17:00",
                    "2026-09-04T18:00",
                    "2026-09-04T19:00",
                    "2026-09-04T20:00",
                    "2026-09-04T21:00",
                    "2026-09-04T22:00",
                    "2026-09-04T23:00"
                ],
                "temperature_2m": [
                    18.2,
                    18.2,
                    18.4,
                    18.1,
                    17.9,
                    18.0,
                    18.2,
                    18.9,
                    20.4,
                    21.6,
                    22.2,
                    23.6,
                    24.3,
                    24.2,
                    24.0,
                    21.0,
                    20.5,
                    19.5,
                    17.9,
                    17.6,
                    17.7,
                    17.2,
                    17.1,
                    16.7
                ],
                "wind_speed_10m": [
                    3.31,
                    3.26,
                    3.4,
                    2.82,
                    2.48,
                    2.76,
                    2.91,
                    3.0,
                    3.55,
                    4.1,
                    4.55,
                    6.32,
                    5.35,
                    5.65,
                    5.68,
                    6.1,
                    4.79,
                    5.1,
                    4.83,
                    4.24,
                    4.7,
                    4.73,
                    4.2,
                    4.08
                ],
                "wind_direction_10m": [
                    245,
                    243,
                    256,
                    247,
                    227,
                    224,
                    207,
                    210,
                    212,
                    236,
                    230,
                    247,
                    237,
                    247,
                    256,
                    269,
                    259,
                    259,
                    246,
                    255,
                    268,
                    264,
                    270,
                    259
                ],
                "wind_gusts_10m": [
                    7.5,
                    7.4,
                    8.3,
                    7.3,
                    6.3,
                    5.7,
                    6.1,
                    7.1,
                    8.0,
                    10.2,
                    11.7,
                    13.6,
                    14.0,
                    15.4,
                    13.6,
                    18.0,
                    13.2,
                    11.9,
                    12.5,
                    11.9,
                    11.3,
                    10.9,
                    11.5,
                    9.8
                ]
            }
        }
        EOD;

        $currentMock = <<<EOD
        {
            "latitude": 52.58,
            "longitude": 13.359999,
            "generationtime_ms": 0.12814998626708984,
            "utc_offset_seconds": 0,
            "timezone": "GMT",
            "timezone_abbreviation": "GMT",
            "elevation": 49.0,
            "current_units": {
                "time": "iso8601",
                "interval": "seconds",
                "temperature_2m": "\u00b0C",
                "wind_speed_10m": "m/s",
                "wind_direction_10m": "\u00b0",
                "wind_gusts_10m": "m/s"
            },
            "current": {
                "time": "2026-09-07T19:30",
                "interval": 900,
                "temperature_2m": 18.3,
                "wind_speed_10m": 2.53,
                "wind_direction_10m": 162,
                "wind_gusts_10m": 6.0
            }
        }
        EOD;

        return \OpenAPIServer\Services\WeatherService::createMock($historicMock, $currentMock);
    }

    public static function reportRepository(): \OpenAPIServer\Repositories\ReportRepository
    {
        return new \OpenAPIServer\Repositories\ReportRepository("mysql:dbname=stink_db;host=mysql", "root", "totallyunsafe");
    }

    public static function skipMail(): bool
    {
        return true;
    }

    public static function mailReceivers(): string
    {
        return "";
    }
}
