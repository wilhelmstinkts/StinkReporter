<?php

namespace OpenAPIServer\Parsers;

use OpenAPIServer\Model;

class ReportParser
{
    public static function parseBodyToReport(array $body){
        $report = new \OpenAPIServer\Model\Report;
        $schema = \OpenAPIServer\Model\Report::getOpenApiSchema(true);
        $properties = $schema["properties"];
        foreach ($properties as $key => $value) {
            return $key;
        }        
    }
}