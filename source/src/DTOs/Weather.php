<?php

namespace OpenAPIServer\DTOs;

class Weather
{
    public float $temperature;
    public Wind $wind;

    public function __construct(float $temperature, Wind $wind)
    {
        $this->temperature = $temperature;
        $this->wind = $wind;
    }
}
