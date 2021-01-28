<?php

namespace OpenAPIServer\DTOs;

class Report implements \JsonSerializable
{
    public ?\DateTime $time;
    public ?TimeFrame $timeFrame;
    public Location $location;
    public Stink $stink;
    public ?Reporter $reporter;
    public Weather $weather;

    public function __construct(Location $location, Stink $stink, Weather $weather, ?Reporter $reporter)
    {
        $this->location = $location;
        $this->stink = $stink;
        $this->reporter = $reporter;
        $this->weather = $weather;
    }

    public static function createWithSingleTime(Location $location, \DateTime $time, Stink $stink, Weather $weather, ?Reporter $reporter): Report
    {
        $instance = new Report($location, $stink, $weather, $reporter);
        $instance->time = $time;
        return $instance;
    }

    public static function createWithTimeFrame(Location $location, TimeFrame $timeFrame, Stink $stink, Weather $weather, ?Reporter $reporter): Report
    {
        $instance = new Report($location, $stink, $weather, $reporter);
        $instance->timeFrame = $timeFrame;
        return $instance;
    }

    public function jsonSerialize()
    {
        $serialized = [
            'location' => $this->location,
            'stink' => $this->stink,
            'weather' => $this->weather
        ];
        if (!is_null($this->time)) {
            $serialized['time'] = $this->time->format(\DateTime::ISO8601);
        } else {
            $serialized['startTime'] = $this->timeFrame->startTime->format(\DateTime::ISO8601);
            $serialized['endTime'] = $this->timeFrame->endTime->format(\DateTime::ISO8601);
        }
        return $serialized;
    }
}
