<?php

namespace MeuProjeto\Middleware;

class LogMiddleware
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function handle($uri, $method, $status, $message = null)
    {
        $stmt = $this->pdo->prepare("INSERT INTO logs (endpoint, method, response_status, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$uri, $method, $status, $message]);
    }
}
