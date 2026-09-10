<?php

namespace OpenAPIServer\Parsers;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;
use OpenAPIServer\DTOs;
use OpenAPIServer\DTOs\Wind;
use OpenAPIServer\Services\WeatherService;

class ReportParser
{
    public static function parseBodyToReport(array $body): \OpenAPIServer\DTOs\Report
    {
        if (!isset($body["report"])) {
            throw new Exception("Missing object report in the request body", 1);
        }
        $report = $body["report"];
        $reportSchema = \OpenAPIServer\Model\ReportInput::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($reportSchema, $report);
        $location = ReportParser::parseLocation($report["location"] ?? null);
        $stink = ReportParser::parseStink($report["stink"] ?? null);
        $reporter = ReportParser::parseReporter($report["reporter"] ?? null);
        $submittedWeather = ReportParser::parseWeather($report["weather"] ?? null);

        if (!isset($report["timeFrame"])) {
            $time = new DateTime("now", new \DateTimeZone("UTC"));
            $weather = $submittedWeather
                ?? \Environment\Environment::weatherService()->getCurrentWeather($location->coordinates);
            return new \OpenAPIServer\DTOs\Report($location, $stink, $weather, $time, $reporter);
        }

        $timeFrame = ReportParser::parseTimeFrame($report["timeFrame"]);
        $weather = $submittedWeather
            ?? \Environment\Environment::weatherService()
                ->getHistoricWeather($location->coordinates, $timeFrame->averageTime());
        return \OpenAPIServer\DTOs\Report::createWithTimeFrame($location, $timeFrame, $stink, $weather, $reporter);
    }

    private static function throwOnMissingProps(array $schema, $given)
    {
        if (!is_array($given)) {
            $type = gettype($given);
            throw new Exception("Expected an object but got $given with type $type", 1);
        }

        foreach ($schema["properties"] as $propertyName => $value) {
            if (!isset($given[$propertyName])) {
                if (in_array($propertyName, $schema["required"])) {
                    throw new Exception("Required attribute $propertyName missing.");
                }
            }
        }
    }

    /**
     * The client may send the weather it already looked up, so the server does
     * not have to fetch it a second time. Returns null when nothing was sent,
     * in which case the caller falls back to looking it up itself.
     */
    private static function parseWeather($weather): ?\OpenAPIServer\DTOs\Weather
    {
        if (is_null($weather)) {
            return null;
        }

        $weatherSchema = \OpenAPIServer\Model\Weather::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($weatherSchema, $weather);

        $wind = $weather["wind"];
        $windSchema = \OpenAPIServer\Model\Wind::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($windSchema, $wind);

        $direction = ReportParser::toNumber($wind["direction"], "wind direction");
        $speed = ReportParser::toNumber($wind["speed"], "wind speed");
        $gustSpeed = isset($wind["gustSpeed"])
            ? ReportParser::toNumber($wind["gustSpeed"], "gust speed")
            : null;

        if ($direction < 0 || $direction > 360) {
            throw new Exception("Wind direction must be between 0 and 360 degrees", 1);
        }
        if ($speed < 0 || (!is_null($gustSpeed) && $gustSpeed < 0)) {
            throw new Exception("Wind speeds cannot be negative", 1);
        }

        return new \OpenAPIServer\DTOs\Weather(
            ReportParser::toNumber($weather["temperature"], "temperature"),
            new \OpenAPIServer\DTOs\Wind($direction, $speed, $gustSpeed)
        );
    }

    private static function toNumber($value, string $name): float
    {
        if (!is_numeric($value)) {
            throw new Exception("Expected a number for $name", 1);
        }
        return (float) $value;
    }

    private static function parseStink($stink): \OpenAPIServer\DTOs\Stink
    {
        $stinkSchema = \OpenAPIServer\Model\Stink::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($stinkSchema, $stink);
        return new  \OpenAPIServer\DTOs\Stink($stink["kind"], $stink["intensity"]);
    }

    private static function parseReporter($reporter): \OpenAPIServer\DTOs\Reporter
    {
        $reporterSchema = \OpenAPIServer\Model\Reporter::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($reporterSchema, $reporter);
        return new  \OpenAPIServer\DTOs\Reporter($reporter["name"], $reporter["email"]);
    }

    private static function parseTimeFrame($timeframe): \OpenAPIServer\DTOs\TimeFrame
    {
        $timeFrameSchema = \OpenAPIServer\Model\TimeFrame::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($timeFrameSchema, $timeframe);
        $startTime = \OpenAPIServer\Parsers\TimeParser::parseTime($timeframe["startTime"]);
        $endTime = \OpenAPIServer\Parsers\TimeParser::parseTime($timeframe["endTime"]);
        return new \OpenAPIServer\DTOs\TimeFrame($startTime, $endTime);
    }

    private static function parseLocation($location): \OpenAPIServer\DTOs\Location
    {
        if (!is_array($location)) {
            $type = gettype($location);
            throw new Exception("Expected an object as location but got $location with type $type", 1);
        }
        $address = null;
        $adressArray = $location["address"] ?? null;
        $coordinatesArray = $location["coordinates"] ?? null;
        $isHome = $location["isHome"] ?? null;
        if (!is_null($isHome) && !is_bool($isHome)) {
            $type = gettype($isHome);
            throw new Exception("Expected a boolean for isHome but got type $type", 1);
        }

        $hasAddress = !\is_null($adressArray);

        if ($hasAddress) {
            $address = ReportParser::parseAndValidateAddress($adressArray);
        }

        $coordinateSchema = \OpenAPIServer\Model\Coordinates::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($coordinateSchema, $coordinatesArray);
        $coordinates = ReportParser::parseAndvalidateCoordinates($coordinatesArray);

        return new \OpenAPIServer\DTOs\Location($address, $coordinates, $isHome);
    }

    private static function parseAndValidateAddress($address): \OpenAPIServer\DTOs\Address
    {
        $_validStates = ["Germany"];
        $_validCities = ["Berlin"];
        $_validZips = ["13158"];

        if (!in_array($address["country"] ?? null, $_validStates)) {
            throw new Exception("We currently only support " . implode(",", $_validStates), 1);
        }

        if (!in_array($address["city"] ?? null, $_validCities)) {
            throw new Exception("We currently only support " . implode(",", $_validCities), 1);
        }
        if (!in_array($address["zip"] ?? null, $_validZips)) {
            throw new Exception("We currently only support " . implode(",", $_validZips), 1);
        }

        return new \OpenAPIServer\DTOs\Address(
            $address["street"] ?? null,
            $address["number"] ?? null,
            $address["zip"] ?? null,
            $address["city"] ?? null,
            $address["country"] ?? null
        );
    }

    private static function parseAndValidateCoordinates($coordinates): \OpenAPIServer\DTOs\Coordinates
    {
        $_southNorthBorders = [52.58,  52.5933];
        $_eastWestBorders = [13.3466, 13.375];
        $longitude = $coordinates["longitude"] ?? null;
        $latitude = $coordinates["latitude"] ?? null;

        $valid = $longitude >= $_eastWestBorders[0] && $longitude <= $_eastWestBorders[1] && $latitude >= $_southNorthBorders[0] && $latitude <= $_southNorthBorders[1];

        if (!$valid) {
            throw new Exception("We currently only support Wilhelmsruh. It looks like you're out of its boundaries", 1);
        }

        return new \OpenAPIServer\DTOs\Coordinates($longitude, $latitude);
    }
}
