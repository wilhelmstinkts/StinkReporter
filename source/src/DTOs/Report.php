<?php

namespace OpenAPIServer\DTOs;

class Report{
    public \DateTime $time;
    public Location $location;
    public Stink $stink;
    public Reporter $reporter;

    public function __construct(Location $location, \DateTime $time, Stink $stink, Reporter $reporter) {
        $this->location = $location;
        $this->time = $time;
        $this->stink = $stink;
        $this->reporter = $reporter;
    }
}