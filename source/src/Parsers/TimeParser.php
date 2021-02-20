<?php

namespace OpenAPIServer\Parsers;


class TimeParser
{
    public static function parseTime(string $isoString): \DateTime
    {
        $parsed = \DateTime::createFromFormat("Y-m-d\TH:i:s.vO", $isoString);
        if (!$parsed) {
            throw new \InvalidArgumentException("${isoString} does not represent a valid DateTime", 1);       
        }
        return $parsed;
    }
}
