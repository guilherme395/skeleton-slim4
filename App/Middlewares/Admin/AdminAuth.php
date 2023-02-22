<?php

namespace App\Middlewares\Admin;

use Firebase\JWT\JWT;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class AdminAuth extends Controller
{
    private const ADMIN_TOKEN_KEY = "66586169";

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $adminToken = $request->getCookieParams()["adminToken"] ?? null;

        if (!$adminToken) {
            return $this->redirectAdminLogin();
        }

        if (!$this->validateToken($adminToken, self::ADMIN_TOKEN_KEY)) {
            return $this->redirectAdminLogin();
        }
        return $handler->handle($request);
    }

    private function redirectAdminLogin(): Response
    {
        $this->view("Admin/Login", ["title" => "Faça Login!"]);
        return $this->response;
    }

    private function validateToken(string $token, string $tokenKey): bool
    {
        $decodedToken = JWT::decode($token, $tokenKey, ["HS256"]);
        return isset($decodedToken->expired_at)
            && strtotime($decodedToken->expired_at) < date("d/m/Y H:i:s");
    }
}
