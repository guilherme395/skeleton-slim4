<?php

namespace App\Controllers\Security;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controllers\Controller;

final class AuthAdminController extends Controller
{
    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        if (empty($data["NomeUsuario"]) || empty($data["SenhaUsuario"])) {
            return $this->errorResponse($response, "É necessário passar nome e senha.", 422);
        }

        $user = $this->user->where("name", $data["NomeUsuario"])->first();
        if (!$user || $user->password !== $data["SenhaUsuario"]) {
            return $this->errorResponse($response, "Autenticação falhou.", 401);
        }

        $expiry = time() + 3600; // Expira em 1 hora
        $token = JWT::encode([
            "user_id" => $user->id,
            "user_type" => "Admin",
            "expired_at" => date("d/m/Y H:i:s", $expiry)
        ], "66586169");

        $successData = [
            "Success" => [
                "Message" => "Administrador autenticado com sucesso!"
            ]
        ];
        $cookieHeader = "adminToken=$token; Expires=" . date("d/m/Y H:i:s", $expiry) . "; Path=/; HttpOnly; SameSite=Strict";
        return $this->renderer->json($response, $successData, 201)->withHeader("Set-Cookie", $cookieHeader);
    }

    private function errorResponse(Response $response, string $message, int $statusCode): Response
    {
        return $this->renderer->json($response, [
            "Error" => [
                "Message" => $message
            ]
        ], $statusCode);
    }
}
