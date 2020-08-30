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
use OpenAPIServer\Model\ReportOutput;

/**
 * ReportOutputTest Class Doc Comment
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 *
 * @coversDefaultClass \OpenAPIServer\Model\ReportOutput
 */
class ReportOutputTest extends TestCase
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
     * Test "ReportOutput"
     */
    public function testReportOutput()
    {
        $testReportOutput = new ReportOutput();
        $namespacedClassname = ReportOutput::getModelsNamespace() . '\\ReportOutput';
        $this->assertSame('\\' . ReportOutput::class, $namespacedClassname);
        $this->assertTrue(
            class_exists($namespacedClassname),
            sprintf('Assertion failed that "%s" class exists', $namespacedClassname)
        );
        $this->markTestIncomplete(
            'Test of "ReportOutput" model has not been implemented yet.'
        );
    }

    /**
     * Test attribute "time"
     */
    public function testPropertyTime()
    {
        $this->markTestIncomplete(
            'Test of "time" property in "ReportOutput" model has not been implemented yet.'
        );
    }

    /**
     * Test attribute "wind"
     */
    public function testPropertyWind()
    {
        $this->markTestIncomplete(
            'Test of "wind" property in "ReportOutput" model has not been implemented yet.'
        );
    }

    /**
     * Test attribute "location"
     */
    public function testPropertyLocation()
    {
        $this->markTestIncomplete(
            'Test of "location" property in "ReportOutput" model has not been implemented yet.'
        );
    }

    /**
     * Test attribute "stink"
     */
    public function testPropertyStink()
    {
        $this->markTestIncomplete(
            'Test of "stink" property in "ReportOutput" model has not been implemented yet.'
        );
    }

    /**
     * Test getOpenApiSchema static method
     * @covers ::getOpenApiSchema
     */
    public function testGetOpenApiSchema()
    {
        $schemaArr = ReportOutput::getOpenApiSchema();
        $this->assertIsArray($schemaArr);
    }
}