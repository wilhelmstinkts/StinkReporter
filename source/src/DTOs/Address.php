<?php

namespace OpenAPIServer\DTOs;

class Address{     
    public string $street;
    public string $number;
    public string $zip;
    public string $city;
    public string $country;

    public function __construct(string $street, string $number, string $zip, string $city, string $country) {
        $this->street = $street;
        $this->number = $number;
        $this->zip = $zip;
        $this->country = $country;
        $this->city = $city;
    }
}