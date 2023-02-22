<?php

namespace App\Controllers;

use Nyholm\Psr7\Response;
use App\Utilities\JsonRenderer;
use League\Plates\Engine;
use App\Models\User;

abstract class Controller
{
    protected Response $response;
    protected JsonRenderer $renderer;
    protected User $user;

    public function __construct()
    {
        $this->response = new Response();
        $this->renderer = new JsonRenderer();
        $this->user = new User();
    }

    public static function view(string $view, array $data = []): void
    {
        $viewPath = dirname(__DIR__, 1) . "/Views";

        if (!file_exists("$viewPath/$view.php")) {
            http_response_code(404);
            self::view("Exceptions/404", ["title" => "404 Não Encontrado"]);
            return;
        }

        $templates = new Engine($viewPath);
        echo $templates->render($view, $data);
    }
}
