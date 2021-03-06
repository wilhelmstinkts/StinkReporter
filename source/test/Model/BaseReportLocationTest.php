<?php

/**
 * Stink Reporter
 * PHP version 7.2
 *
 * @package OpenAPIServer
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */

/**
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
use OpenAPIServer\Model\BaseReportLocation;

/**
 * BaseReportLocationTest Class Doc Comment
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 *
 * @coversDefaultClass \OpenAPIServer\Model\BaseReportLocation
 */
class BaseReportLocationTest extends TestCase
{

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass(): void
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp(): void
    {
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown(): void
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass(): void
    {
    }

    /**
     * Test "BaseReportLocation"
     */
    public function testBaseReportLocation()
    {
        $testBaseReportLocation = new BaseReportLocation();
        $namespacedClassname = BaseReportLocation::getModelsNamespace() . '\\BaseReportLocation';
        $this->assertSame('\\' . BaseReportLocation::class, $namespacedClassname);
        $this->assertTrue(
            class_exists($namespacedClassname),
            sprintf('Assertion failed that "%s" class exists', $namespacedClassname)
        );
        $this->markTestIncomplete(
            'Test of "BaseReportLocation" model has not been implemented yet.'
        );
    }

    /**
     * Test attribute "address"
     */
    public function testPropertyAddress()
    {
        $this->markTestIncomplete(
            'Test of "address" property in "BaseReportLocation" model has not been implemented yet.'
        );
    }

    /**
     * Test attribute "coordinates"
     */
    public function testPropertyCoordinates()
    {
        $this->markTestIncomplete(
            'Test of "coordinates" property in "BaseReportLocation" model has not been implemented yet.'
        );
    }

    /**
     * Test getOpenApiSchema static method
     * @covers ::getOpenApiSchema
     */
    public function testGetOpenApiSchema()
    {
        $schemaArr = BaseReportLocation::getOpenApiSchema();
        $this->assertIsArray($schemaArr);
    }
}
