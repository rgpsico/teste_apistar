<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Requests\LoginRequest;
use MeuProjeto\Requests\RegisterRequest;
use MeuProjeto\Services\AuthService;
use MeuProjeto\Traits\ValidatesRequests;
use MeuProjeto\Validation\Validator;

class AuthController
{
    use ValidatesRequests;

    protected $authService;
    protected $pdo;

    public function __construct($pdo)
    {
        $this->authService = new AuthService($pdo);
        $this->pdo = $pdo;
    }

    public function validacaoRegister($data)
    {
        // Usar a classe RegisterRequest para validar os dados
        $request = new RegisterRequest($data, $this->pdo);
        $errors = $request->validate();

        if ($errors) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Erro de validação.',
                'errors' => $errors,
            ]);
            exit;
        }
    }

    public function register()
    {
        // Ler o corpo da requisição e decodificar o JSON
        $data = json_decode(file_get_contents('php://input'), true);

        $this->validateWith(RegisterRequest::class, $data, $this->pdo);

        // Registrar o usuário no serviço
        try {
            $this->authService->register($data['name'], $data['email'], $data['password']);
            echo json_encode(['message' => 'Usuário registrado com sucesso.']);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Erro ao registrar usuário.', 'error' => $e->getMessage()]);
        }
    }



    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $token = $this->authService->login($data['email'], $data['password']);

        $this->validateWith(LoginRequest::class, $data, $this->pdo);

        if ($token) {
            echo json_encode(['token' => $token]);
            http_response_code(200);
            return;
        }
        http_response_code(401);
        echo json_encode(['message' => 'Credenciais inválidas.']);
    }


    public function user()
    {
        // Pegando o header Authorization
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? getallheaders()['Authorization'] ?? null;

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(['error' => 'Token não fornecido.']);
            return;
        }

        // Remover o prefixo 'Bearer ' do token
        $token = str_replace('Bearer ', '', $authHeader);

        // Buscar o usuário pelo token
        $user = $this->authService->getUserByToken($token);

        if ($user) {
            echo json_encode(['name' => $user['name'], 'email' => $user['email']]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Usuário não autenticado.']);
        }
    }




    public function logout()
    {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;

        if ($token) {
            $this->authService->logout($token);
            return json_encode(['message' => 'Logout realizado com sucesso.']);
        } else {
            http_response_code(400);
            return json_encode(['message' => 'Token não fornecido.']);
        }
    }
}
