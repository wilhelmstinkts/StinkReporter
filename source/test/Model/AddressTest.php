<?php

/**
 * AddressTest
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
use OpenAPIServer\Model\Address;

/**
 * AddressTest Class Doc Comment
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 *
 * @coversDefaultClass \OpenAPIServer\Model\Address
 */
class AddressTest extends TestCase
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
     * Test "Address"
     */
    public function testAddress()
    {
        $testAddress = new Address();
    }

    /**
     * Test attribute "street"
     */
    public function testPropertyStreet()
    {
    }

    /**
     * Test attribute "number"
     */
    public function testPropertyNumber()
    {
    }

    /**
     * Test attribute "zip"
     */
    public function testPropertyZip()
    {
    }

    /**
     * Test attribute "city"
     */
    public function testPropertyCity()
    {
    }

    /**
     * Test attribute "country"
     */
    public function testPropertyCountry()
    {
    }

    /**
     * Test getOpenApiSchema static method
     * @covers ::getOpenApiSchema
     */
    public function testGetOpenApiSchema()
    {
        $schemaObject = Address::getOpenApiSchema();
        $schemaArr = Address::getOpenApiSchema(true);
        $this->assertIsObject($schemaObject);
        $this->assertIsArray($schemaArr);
    }
}
