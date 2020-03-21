<?php

namespace OpenAPIServer\Parsers;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;

class ReportParser
{
    public static function parseBodyToReport(array $body){
        if (is_null($body["report"])) {
            throw new Exception("Missing object report in the request body", 1);           
        }        
        $report = $body["report"];
        $reportSchema = \OpenAPIServer\Model\Report::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($reportSchema, $report);
        $time = ReportParser::parseTime($report["time"]);
        $stinkSchema = \OpenAPIServer\Model\Stink::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($stinkSchema, $report["stink"]);
        $reporterSchema = \OpenAPIServer\Model\Reporter::getOpenApiSchema(true);
        ReportParser::throwOnMissingProps($reporterSchema, $report["reporter"]);

        $location = ReportParser::parseLocation($report["location"]);
        return $location;
    }

    private static function throwOnMissingProps(array $schema, $given){
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

    private static function parseTime(string $timeString){
        $time = DateTime::createFromFormat(DateTimeInterface::ISO8601, $timeString); 
        if ($time == false) {
            throw new Exception("$timeString is not a valid time", 1);            
        }
        return $time;
    }

    private static function parseLocation($location){
        if (!is_array($location)) {
            $type = gettype($location);
            throw new Exception("Expected an object as location but got $location with type $type", 1);            
        }
        $address = $location["address"];
        $coordinates = $location["coordinates"];
        $hasAddress = !\is_null($address);
        $hasCoordinates = !\is_null($coordinates);
        if (!($hasAddress || $hasCoordinates)) {
            throw new Exception("You must provide an address or coordinates", 1);            
        }

        if ($hasAddress) {
            $addressSchema = \OpenAPIServer\Model\Address::getOpenApiSchema(true);
            ReportParser::throwOnMissingProps($addressSchema, $address);
            ReportParser::validateAddress($address);
        }

        if ($hasCoordinates) {
            $coordinateSchema = \OpenAPIServer\Model\Coordinates::getOpenApiSchema(true);
            ReportParser::throwOnMissingProps($coordinateSchema, $coordinates);
            ReportParser::validateCoordinates($coordinates);
        }

        if ($hasAddress && !$hasCoordinates) {
            $coordinates = ReportParser::getCoordinatesForAddress($address);
        }

        if (!$hasAddress && $hasCoordinates) {
            $address = ReportParser::getAddressForCoordinates($coordinates);
        }

        return [ "address" => $address, "coordinates" => $coordinates ];
    }

    private static function validateAddress($address){
        $_validStates = ["Germany"];
        $_validCities = ["Berlin"];
        $_validZips = ["13158"];

        if (!in_array($address["country"], $_validStates)) {
            throw new Exception("We currently only support ".implode( ",", $_validStates ), 1);
        }

        if (!in_array($address["city"], $_validCities)) {
            throw new Exception("We currently only support ".implode( ",", $_validCities ), 1);
        } 
        if (!in_array($address["zip"], $_validZips)) {
            throw new Exception("We currently only support ".implode( ",", $_validZips ), 1);
        }
    }

    private static function validateCoordinates($coordinates){       
        $_southNorthBorders = [52.58,  52.5933];
        $_eastWestBorders = [13.3466, 13.375];
        $longitude = $coordinates["longitude"];
        $latitude = $coordinates["latitude"];
        $valid = $longitude >= $_southNorthBorders[0] && $longitude <= $_southNorthBorders[1] && $latitude >= $_eastWestBorders[0] && $latitude <= $_eastWestBorders[1];
        
        if (!$valid) {
            throw new Exception("We currently only support Wilhelmsruh. It looks like you're out of its boundaries", 1); }
        }

    private static function getCoordinatesForAddress($address){
        throw new Exception("Not implemented", 1);        
    }

    private static function getAddressForCoordinates($coordinates){
        throw new Exception("Not implemented", 1);        
    }
}