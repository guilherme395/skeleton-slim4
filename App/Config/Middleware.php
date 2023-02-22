<?php

namespace App\Config;

use League\Plates\Engine;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Middleware
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (HttpNotFoundException $e) {
            $viewPath = dirname(__DIR__) . "/Views";
            $response = $this->app->getResponseFactory()->createResponse(404);
            $templates = new Engine($viewPath);
            $response->getBody()->write($templates->render("Exceptions/404", ["title" => "404 Não Encontrado"]));
            return $response->withStatus(404);
        }
    }
}
