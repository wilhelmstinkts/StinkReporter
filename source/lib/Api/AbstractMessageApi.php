<?php

/**
 * AbstractMessageApi
 *
 * PHP version 7.1
 *
 * @package OpenAPIServer\Api
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
 * Do not edit the class manually.
 */
namespace OpenAPIServer\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Exception;

/**
 * AbstractMessageApi Class Doc Comment
 *
 * @package OpenAPIServer\Api
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */
abstract class AbstractMessageApi
{

    /**
     * @var ContainerInterface|null Slim app container instance
     */
    protected $container;

    /**
     * Route Controller constructor receives container
     *
     * @param ContainerInterface|null $container Slim app container instance
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * GET getMessages
     * Output-Formats: [application/json, text/plain]
     *
     * @param ServerRequestInterface $request  Request
     * @param ResponseInterface      $response Response
     * @param array|null             $args     Path arguments
     *
     * @return ResponseInterface
     * @throws Exception to force implementation class to override this method
     */
    public function getMessages(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $message = "How about implementing getMessages as a GET method in OpenAPIServer\Api\MessageApi class?";
        throw new Exception($message);

        $response->getBody()->write($message);
        return $response->withStatus(501);
    }

    /**
     * POST postNewMessage
     * Output-Formats: [text/plain]
     *
     * @param ServerRequestInterface $request  Request
     * @param ResponseInterface      $response Response
     * @param array|null             $args     Path arguments
     *
     * @return ResponseInterface
     * @throws Exception to force implementation class to override this method
     */
    public function postNewMessage(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        $message = "How about implementing postNewMessage as a POST method in OpenAPIServer\Api\MessageApi class?";
        throw new Exception($message);

        $response->getBody()->write($message);
        return $response->withStatus(501);
    }
}
