<?php

namespace OpenAPIServer\Api;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use OpenAPIServer\Model;
use OpenAPIServer\Parsers;

/**
 * AbstractReportApi Class Doc Comment
 *
 * @package OpenAPIServer\Api
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */
class ReportApi extends AbstractReportApi
{
    

    public function getReports(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $response->getBody()->write("I am a stub");
        return $response->withStatus(400);
    }

    public function postNewReport(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $requestBody = $request->getParsedBody();
            if (is_null($requestBody)) {
                throw new Exception("Request body is invalid json or empty", 1);
            }
            $report = \OpenAPIServer\Parsers\ReportParser::parseBodyToReport($requestBody);
            $mailSuccess = \OpenAPIServer\Services\MailService::sendMail($report);
            if (!$mailSuccess) {
                $response->getBody()->write("Mail could not be sent");
                return $response->withStatus(500);
            }
            $response->getBody()->write("Successfully ingested report");
            return $response->withStatus(201);
        } catch (Exception $e) {
            $response->getBody()->write($e->getMessage());
            return $response->withStatus(400);
        }
    }
}
