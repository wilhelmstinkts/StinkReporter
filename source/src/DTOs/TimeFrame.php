<?php

namespace OpenAPIServer\DTOs;

use DateTime;

class TimeFrame
{
    public \DateTime $startTime;
    public \DateTime $endTime;

    public function __construct(\DateTime $startTime, \DateTime $endTime)
    {
        if ($endTime <= $startTime) {
            throw new \InvalidArgumentException("EndTime must be after startTime", 1);
        }
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function averageTime(): DateTime
    {
        $result = new DateTime();
        $result->setTimestamp(($this->startTime->getTimestamp() + $this->endTime->getTimestamp()) / 2);
        return $result;
    }
}
