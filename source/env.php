<?php

// For test purposes only! Do not put production variables in here!
namespace Environment;

class Environment
{
    public static function weatherService(): \OpenAPIServer\Services\WeatherService
    {
        return new \OpenAPIServer\Services\WeatherService("https://samples.openweathermap.org/data/2.5/weather", "439d4b804bc8187953eb36d2a8c26a02");
    }

    public static function reportRepository(): \OpenAPIServer\Repositories\ReportRepository
    {
        return new \OpenAPIServer\Repositories\ReportRepository("mysql:dbname=stink_db;host=172.17.0.2", "root", "totallyunsafe");
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
