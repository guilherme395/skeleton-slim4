<?php

namespace App\Controllers\App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\COntrollers\Controller;

final class HomeController extends Controller
{
    public function __invoke(Request $req, Response $res): Response
    {
        $this->view("App/Home", ["title" => "Home"]);
        return $res;
    }
}
