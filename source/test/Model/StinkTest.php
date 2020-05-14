<?php

/**
 * StinkTest
 *
 * PHP version 7.1
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */

/**
 * Stink Reporter
 *
 * Report when and where it stinks and query for past stinks.
 * The version of the OpenAPI document: 0.0.0
 * Generated by: https://github.com/openapitools/openapi-generator.git
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Please update the test case below to test the model.
 */
namespace OpenAPIServer\Model;

use PHPUnit\Framework\TestCase;
use OpenAPIServer\Model\Stink;

/**
 * StinkTest Class Doc Comment
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 *
 * @coversDefaultClass \OpenAPIServer\Model\Stink
 */
class StinkTest extends TestCase
{

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass()
    {
    }

    /**
     * Test "Stink"
     */
    public function testStink()
    {
        $testStink = new Stink();
    }

    /**
     * Test attribute "kind"
     */
    public function testPropertyKind()
    {
    }

    /**
     * Test attribute "intensity"
     */
    public function testPropertyIntensity()
    {
    }

    /**
     * Test getOpenApiSchema static method
     *
     * @covers ::getOpenApiSchema
     */
    public function testGetOpenApiSchema()
    {
        $schemaObject = Stink::getOpenApiSchema();
        $schemaArr = Stink::getOpenApiSchema(true);
        $this->assertIsObject($schemaObject);
        $this->assertIsArray($schemaArr);
    }
}
