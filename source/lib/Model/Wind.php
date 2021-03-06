<?php

/**
 * Wind
 *
 * PHP version 7.1
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 */
namespace OpenAPIServer\Model;

use OpenAPIServer\Interfaces\ModelInterface;

/**
 * Wind
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */
class Wind implements ModelInterface
{
    private const MODEL_SCHEMA = <<<'SCHEMA'
{
  "required" : [ "direction", "speed" ],
  "type" : "object",
  "properties" : {
    "direction" : {
      "type" : "number",
      "example" : 270
    },
    "speed" : {
      "type" : "number",
      "example" : 3.5
    },
    "gustSpeed" : {
      "type" : "number",
      "example" : 12.7
    }
  }
}
SCHEMA;

    /** @var float $direction */
    private $direction;

    /** @var float $speed */
    private $speed;

    /** @var float $gustSpeed */
    private $gustSpeed;

    /**
     * Returns model schema.
     *
     * @param bool $assoc When TRUE, returned objects will be converted into associative arrays. Default FALSE.
     *
     * @return array
     */
    public static function getOpenApiSchema($assoc = false)
    {
        return json_decode(static::MODEL_SCHEMA, $assoc);
    }
}
