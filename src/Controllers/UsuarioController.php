<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Services\UsuarioService;

class UsuarioController
{
    protected $service;

    public function __construct($pdo)
    {
        $this->service = new UsuarioService($pdo);
    }

    // API: Retorna todos os usuários com seus favoritos
    public function all()
    {
        try {
            $users = $this->service->getAllUsersWithFavorites();
            header('Content-Type: application/json');
            echo json_encode($users);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // API: Retorna um usuário pelo ID
    public function show($id)
    {
        try {
            $user = $this->service->getUserById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['message' => 'Usuário não encontrado']);
                return;
            }

            $favorites = $this->service->getFavoritesByUserId($id);
            $user['favorites'] = $favorites;

            header('Content-Type: application/json');
            echo json_encode($user);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
