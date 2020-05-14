<?php

/**
 * Stink
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
 * Stink
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */
class Stink implements ModelInterface
{
    private const MODEL_SCHEMA = <<<'SCHEMA'
{
  "required" : [ "intensity", "kind" ],
  "type" : "object",
  "properties" : {
    "kind" : {
      "type" : "string",
      "example" : "Biomüll"
    },
    "intensity" : {
      "maximum" : 5,
      "minimum" : 1,
      "type" : "number",
      "example" : 3
    }
  }
}
SCHEMA;

    /**
     * @var string $kind
     */
    private $kind;

    /**
     * @var float $intensity
     */
    private $intensity;

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
