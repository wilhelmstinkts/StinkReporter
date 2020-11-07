<?php

namespace OpenAPIServer\DTOs;

class Location
{

    public ?Address $address;
    public ?bool $isHome;
    public Coordinates $coordinates;

    public function __construct(?Address $address, Coordinates $coordinates, ?bool $isHome)
    {
        $this->address = $address;
        $this->coordinates = $coordinates;
        $this->isHome = $isHome;
    }
}
