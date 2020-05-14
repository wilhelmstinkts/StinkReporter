<?php

namespace OpenAPIServer\DTOs;

class Location
{
    
    public ?Address $address;
    public Coordinates $coordinates;
    
    public function __construct(?Address $address, Coordinates $coordinates)
    {
        $this->address = $address;
        $this->coordinates = $coordinates;
    }
}
