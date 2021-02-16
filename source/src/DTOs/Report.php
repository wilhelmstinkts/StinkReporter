<?php

namespace OpenAPIServer\DTOs;

class Report implements \JsonSerializable
{
    public \DateTime $time;
    public ?TimeFrame $timeFrame = null;
    public Location $location;
    public Stink $stink;
    public ?Reporter $reporter;
    public Weather $weather;

    public function __construct(Location $location, Stink $stink, Weather $weather, \DateTime $time, ?Reporter $reporter)
    {
        $this->location = $location;
        $this->stink = $stink;
        $this->reporter = $reporter;
        $this->weather = $weather;
        $this->time = $time;
    }

    public static function createWithTimeFrame(Location $location, TimeFrame $timeFrame, Stink $stink, Weather $weather, ?Reporter $reporter): Report
    {
        $instance = new Report($location, $stink, $weather, $timeFrame->averageTime(), $reporter);
        $instance->timeFrame = $timeFrame;
        return $instance;
    }

    public function jsonSerialize()
    {
        $serialized = [
            'location' => $this->location,
            'stink' => $this->stink,
            'weather' => $this->weather,
            'time' => $this->time->format(\DateTime::ISO8601)
        ];
        return $serialized;
    }
}
