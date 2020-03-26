<?php

namespace OpenAPIServer\Services;

use Exception;

class LocationService
{
    const locationServer = "http://nominatim.openstreetmap.org/";

    public static function getCoordinatesForAddress($address)
    {
        $query="search?country={$address["country"]}&city={$address["city"]}&postalcode={$address["zip"]}&street={$address["number"]}%20{$address["street"]}&format=json";
        return LocationService::executeQuery($query);
    }

    public static function getAddressForCoordinates($coordinates)
    {
        throw new Exception("Not implemented", 1);
        return LocationService::executeQuery($query);
    }

    private static function executeQuery($query){
        $curlClient = curl_init();

        echo self::locationServer.$query."\n";

        //Set the URL that you want to GET by using the CURLOPT_URL option.
        curl_setopt($curlClient, CURLOPT_URL, self::locationServer.$query);

        //Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);

        //Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($curlClient, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_REFERER, 'https://www.wilhelm-gibt-keine-ruh.de/');

        curl_setopt($ch, CURLOPT_USERAGENT, "Curl");

        //Execute the request.
        $response = curl_exec($curlClient);

        if(curl_error($curlClient)) {
            throw new Exception(curl_error($curlClient), 1);
        }

        echo $response."\n";

        //Close the cURL handle.
        curl_close($curlClient);

        return $response;

    }
}
