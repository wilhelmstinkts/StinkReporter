<?php

namespace OpenAPIServer\Services;

use Exception;

class LocationService
{
    const locationServer = "https://nominatim.openstreetmap.org/";

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

        $headers = [            
            'User-Agent: PostmanRuntime/7.23.0'
        ];
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //Execute the request.
        $response = curl_exec($curlClient);

        echo $response."\n";

        //Close the cURL handle.
        curl_close($curlClient);

        return $response;

    }
}
