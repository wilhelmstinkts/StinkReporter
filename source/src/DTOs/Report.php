<?php

namespace OpenAPIServer\DTOs;

class Report implements \JsonSerializable
{
    public \DateTime $time;
    public Location $location;
    public Stink $stink;
    public ?Reporter $reporter;
    public Wind $wind;

    public function __construct(Location $location, \DateTime $time, Stink $stink, Wind $wind, ?Reporter $reporter)
    {
        $this->location = $location;
        $this->time = $time;
        $this->stink = $stink;
        $this->reporter = $reporter;
        $this->wind = $wind;
    }

    public function jsonSerialize()
    {
        return [
            'time' => $this->time->format(\DateTime::ISO8601),
            'location' => $this->location,
            'stink' => $this->stink,
            'wind' => $this->wind
        ];
    }
}
