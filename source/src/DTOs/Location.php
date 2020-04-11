<?php

namespace OpenAPIServer\DTOs;

class Location{    
     public ?Address $adress;
     public Coordinates $coordinates;
    
     public function __construct(?Adress $address, Coordinates $coordinates) {
        $this->address = $address;
        $this->coordinates = $coordinates;
    }
}