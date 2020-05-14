<?php

namespace OpenAPIServer\DTOs;

class Coordinates
{
    public float $longitude;
    public float $latitude;
    public function __construct(float $longitude, float $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }
}
