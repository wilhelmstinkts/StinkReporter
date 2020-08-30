<?php

namespace OpenAPIServer\Parsers;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;
use OpenAPIServer\DTOs;
use OpenAPIServer\DTOs\Wind;

class ReportParser
{
    public static function parseBodyToReport(array $body): \OpenAPIServer\DTOs\Report
    {
        if (is_null($body["report"])) {
            throw new Exception("Missing object report in the request body", 1);
        }
        $report = $body["report"];
        $reportSchema = \OpenAPIServer\Model\Report::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($reportSchema, $report);
        $location = ReportParser::parseLocation($report["location"]);
        $wind = new Wind(50, 1, 3);
        $time = new DateTime("now");
        $stink = ReportParser::parseStink($report["stink"]);
        $reporter = ReportParser::parseReporter($report["reporter"]);
        return new \OpenAPIServer\DTOs\Report($location, $time, $stink, $wind, $reporter);
    }

    private static function throwOnMissingProps(array $schema, $given)
    {
        if (!is_array($given)) {
            $type = gettype($given);
            throw new Exception("Expected an object but got $given with type $type", 1);
        }

        foreach ($schema["properties"] as $propertyName => $value) {
            if (is_null($given[$propertyName])) {
                if (in_array($propertyName, $schema["required"])) {
                    throw new Exception("Required attribute $propertyName missing.");
                }
            }
        }
    }

    private static function parseStink(array $stink): \OpenAPIServer\DTOs\Stink
    {
        $stinkSchema = \OpenAPIServer\Model\Stink::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($stinkSchema, $stink);
        return new  \OpenAPIServer\DTOs\Stink($stink["kind"], $stink["intensity"]);
    }

    private static function parseReporter(array $reporter): \OpenAPIServer\DTOs\Reporter
    {
        $reporterSchema = \OpenAPIServer\Model\Reporter::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($reporterSchema, $reporter);
        return new  \OpenAPIServer\DTOs\Reporter($reporter["name"], $reporter["email"]);
    }

    private static function parseLocation($location): \OpenAPIServer\DTOs\Location
    {
        if (!is_array($location)) {
            $type = gettype($location);
            throw new Exception("Expected an object as location but got $location with type $type", 1);
        }
        $adress = null;
        $adressArray = $location["address"];
        $coordinatesArray = $location["coordinates"];
        $hasAddress = !\is_null($adressArray);

        if ($hasAddress) {
            $address = ReportParser::parseAndValidateAddress($adressArray);
        }


        $coordinateSchema = \OpenAPIServer\Model\Coordinates::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($coordinateSchema, $coordinatesArray);
        $coordinates = ReportParser::parseAndvalidateCoordinates($coordinatesArray);

        return new \OpenAPIServer\DTOs\Location($address, $coordinates);
    }

    private static function parseAndValidateAddress($address): \OpenAPIServer\DTOs\Address
    {
        $_validStates = ["Germany"];
        $_validCities = ["Berlin"];
        $_validZips = ["13158"];

        if (!in_array($address["country"], $_validStates)) {
            throw new Exception("We currently only support " . implode(",", $_validStates), 1);
        }

        if (!in_array($address["city"], $_validCities)) {
            throw new Exception("We currently only support " . implode(",", $_validCities), 1);
        }
        if (!in_array($address["zip"], $_validZips)) {
            throw new Exception("We currently only support " . implode(",", $_validZips), 1);
        }

        return new \OpenAPIServer\DTOs\Address($address["street"], $address["number"], $address["zip"], $address["city"], $address["country"]);
    }

    private static function parseAndValidateCoordinates($coordinates): \OpenAPIServer\DTOs\Coordinates
    {
        $_southNorthBorders = [52.58,  52.5933];
        $_eastWestBorders = [13.3466, 13.375];
        $longitude = $coordinates["longitude"];
        $latitude = $coordinates["latitude"];

        $valid = $longitude >= $_eastWestBorders[0] && $longitude <= $_eastWestBorders[1] && $latitude >= $_southNorthBorders[0] && $latitude <= $_southNorthBorders[1];

        if (!$valid) {
            throw new Exception("We currently only support Wilhelmsruh. It looks like you're out of its boundaries", 1);
        }

        return new \OpenAPIServer\DTOs\Coordinates($longitude, $latitude);
    }
}
