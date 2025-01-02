<?php

namespace MeuProjeto\Middleware;

use MeuProjeto\Services\AuthService;

class AuthMiddleware
{
    protected $authService;

    public function __construct($pdo)
    {
        $this->authService = new AuthService($pdo);
    }

    public function handle($next)
    {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;

        if ($token && $this->authService->authenticate($token)) {
            $next();
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Não autorizado.']);
            exit;
        }
    }
}
