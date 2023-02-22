<?php

namespace App\Middlewares\App;

use Firebase\JWT\JWT;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class UserAuth extends Controller
{
    private const TOKEN_KEY = "66586169";

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $Token = $request->getCookieParams()["Token"] ?? null;

        if (!$Token) {
            return $this->redirectLogin();
        }

        if (!$this->validateToken($Token, self::TOKEN_KEY)) {
            return $this->redirectLogin();
        }
        return $handler->handle($request);
    }

    private function redirectLogin(): Response
    {
        $this->view("App/Login", ["title" => "Faça Login!"]);
        return $this->response;
    }

    private function validateToken(string $token, string $tokenKey): bool
    {
        $decodedToken = JWT::decode($token, $tokenKey, ["HS256"]);
        return isset($decodedToken->expired_at)
            && strtotime($decodedToken->expired_at) < date("d/m/Y H:i:s");
    }
}
