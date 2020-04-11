<?php

namespace OpenAPIServer\DTOs;

class Stink{
    public string $kind;
    public float $intensity;

    public function __construct(string $kind, float $intensity) {
        $this->kind = $kind;
        $this->intensity = $intensity;
    }
}