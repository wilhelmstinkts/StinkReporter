<?php

// For test purposes only! Do not put production variables in here!
namespace Environment;

class Environment
{
    public static function weatherService(): \OpenAPIServer\Services\WeatherService
    {
        $mock = <<<EOD
        {
            "lat": 52.5875,
            "lon": 13.3629,
            "timezone": "Europe/Berlin",
            "timezone_offset": 3600,
            "current": {
                "dt": 1614261600,
                "sunrise": 1614232925,
                "sunset": 1614271048,
                "temp": 292.12,
                "feels_like": 287.77,
                "pressure": 1023,
                "humidity": 45,
                "dew_point": 279.93,
                "uvi": 1.62,
                "clouds": 0,
                "visibility": 10000,
                "wind_speed": 5.14,
                "wind_deg": 220,
                "weather": [
                    {
                        "id": 800,
                        "main": "Clear",
                        "description": "clear sky",
                        "icon": "01d"
                    }
                ]
            },
            "hourly": [
                {
                    "dt": 1614211200,
                    "temp": 281.79,
                    "feels_like": 280.4,
                    "pressure": 1028,
                    "humidity": 100,
                    "dew_point": 281.79,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 1.54,
                    "wind_deg": 160,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614214800,
                    "temp": 281.57,
                    "feels_like": 279.77,
                    "pressure": 1027,
                    "humidity": 100,
                    "dew_point": 281.57,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 2.06,
                    "wind_deg": 140,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614218400,
                    "temp": 281.25,
                    "feels_like": 280.09,
                    "pressure": 1027,
                    "humidity": 100,
                    "dew_point": 281.25,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 1.03,
                    "wind_deg": 150,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614222000,
                    "temp": 280.39,
                    "feels_like": 279.03,
                    "pressure": 1027,
                    "humidity": 100,
                    "dew_point": 280.39,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 1.03,
                    "wind_deg": 170,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614225600,
                    "temp": 280.41,
                    "feels_like": 278.69,
                    "pressure": 1027,
                    "humidity": 100,
                    "dew_point": 280.41,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 1.54,
                    "wind_deg": 160,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614229200,
                    "temp": 280.58,
                    "feels_like": 278.9,
                    "pressure": 1020,
                    "humidity": 100,
                    "dew_point": 280.58,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 1.54,
                    "wind_deg": 160,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614232800,
                    "temp": 279.96,
                    "feels_like": 277.78,
                    "pressure": 1020,
                    "humidity": 100,
                    "dew_point": 279.96,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 2.06,
                    "wind_deg": 180,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614236400,
                    "temp": 280.26,
                    "feels_like": 278.28,
                    "pressure": 1021,
                    "humidity": 93,
                    "dew_point": 279.21,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 1.54,
                    "wind_deg": 180,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614240000,
                    "temp": 282.44,
                    "feels_like": 280.35,
                    "pressure": 1021,
                    "humidity": 87,
                    "dew_point": 280.39,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 2.06,
                    "wind_deg": 180,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614243600,
                    "temp": 284.63,
                    "feels_like": 281.5,
                    "pressure": 1024,
                    "humidity": 76,
                    "dew_point": 280.55,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 3.6,
                    "wind_deg": 190,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614247200,
                    "temp": 287.66,
                    "feels_like": 285.23,
                    "pressure": 1023,
                    "humidity": 62,
                    "dew_point": 280.47,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 2.57,
                    "wind_deg": 210,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614250800,
                    "temp": 289.59,
                    "feels_like": 285.13,
                    "pressure": 1024,
                    "humidity": 51,
                    "dew_point": 279.44,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 5.14,
                    "wind_deg": 240,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614254400,
                    "temp": 291.37,
                    "feels_like": 287.29,
                    "pressure": 1024,
                    "humidity": 51,
                    "dew_point": 281.08,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 5.14,
                    "wind_deg": 220,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614258000,
                    "temp": 291.86,
                    "feels_like": 288.03,
                    "pressure": 1023,
                    "humidity": 48,
                    "dew_point": 280.64,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 4.63,
                    "wind_deg": 210,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614261600,
                    "temp": 292.12,
                    "feels_like": 287.77,
                    "pressure": 1023,
                    "humidity": 45,
                    "dew_point": 279.93,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 5.14,
                    "wind_deg": 220,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614265200,
                    "temp": 291.77,
                    "feels_like": 287.35,
                    "pressure": 1023,
                    "humidity": 45,
                    "dew_point": 279.62,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 5.14,
                    "wind_deg": 240,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614268800,
                    "temp": 290.18,
                    "feels_like": 286.56,
                    "pressure": 1023,
                    "humidity": 51,
                    "dew_point": 279.98,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 4.12,
                    "wind_deg": 220,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01d"
                        }
                    ]
                },
                {
                    "dt": 1614272400,
                    "temp": 286.77,
                    "feels_like": 283.08,
                    "pressure": 1022,
                    "humidity": 55,
                    "dew_point": 277.91,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 3.6,
                    "wind_deg": 220,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614276000,
                    "temp": 285.07,
                    "feels_like": 281.94,
                    "pressure": 1024,
                    "humidity": 66,
                    "dew_point": 278.93,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 3.09,
                    "wind_deg": 250,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614279600,
                    "temp": 284.06,
                    "feels_like": 280.59,
                    "pressure": 1024,
                    "humidity": 71,
                    "dew_point": 279.01,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 3.6,
                    "wind_deg": 240,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                },
                {
                    "dt": 1614283200,
                    "temp": 283.78,
                    "feels_like": 280.82,
                    "pressure": 1024,
                    "humidity": 76,
                    "dew_point": 279.73,
                    "clouds": 0,
                    "visibility": 10000,
                    "wind_speed": 3.09,
                    "wind_deg": 250,
                    "weather": [
                        {
                            "id": 800,
                            "main": "Clear",
                            "description": "clear sky",
                            "icon": "01n"
                        }
                    ]
                }
            ]
        }
        EOD;

        return \OpenAPIServer\Services\WeatherService::createMock("https://samples.openweathermap.org/data/2.5", $mock);
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
