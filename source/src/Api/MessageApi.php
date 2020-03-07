<?php

namespace OpenAPIServer\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Exception;

class MessageApi extends AbstractMessageApi
{
   
    public function getMessages(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $messages = array("Huhu", "Hallo", "Hi");
        

        $response->getBody()->write(json_encode($messages));
        return $response->withStatus(200)->withHeader('Content-Type', 'Application/json');
    }

    
    public function postNewMessage(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        $message = "How about implementing postNewMessage as a POST method in OpenAPIServer\Api\MessageApi class?";
        throw new Exception($message);

        $response->getBody()->write($message);
        return $response->withStatus(501);
    }
}
