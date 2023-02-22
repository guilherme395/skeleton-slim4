<?php

namespace App\Utilities;

use Psr\Http\Message\ResponseInterface;

final class JsonRenderer
{
    public function json(ResponseInterface $res, array $data = [], int $statusCode = 200): ResponseInterface
    {
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        $res = $res->withHeader("Content-Type", "application/json")
            ->withStatus($statusCode);
            
        $res->getBody()->write($payload);
        return $res;
    }
}
