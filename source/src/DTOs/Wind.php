<?php

namespace OpenAPIServer\DTOs;

class Wind
{
    public float $direction;
    public float $speed;
    public ?float $gustSpeed;

    public function __construct(float $direction, float $speed, ?float $gustSpeed)
    {
        $this->direction = $direction;
        $this->speed = $speed;
        $this->gustSpeed = $gustSpeed;
    }
}
