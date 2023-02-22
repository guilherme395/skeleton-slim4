<?php

namespace App\Controllers\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\Controller;

final class AdminController extends Controller
{
    public function __invoke(Request $req, Response $res): Response
    {
        $this->view("Admin/Admin", ["title" => "Admin"]);
        return $res;
    }
}
