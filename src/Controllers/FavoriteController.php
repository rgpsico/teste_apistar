<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Services\AuthService;
use MeuProjeto\Services\FavoriteService;

class FavoriteController extends BaseController
{
    protected $favoriteService, $authService;

    public function __construct()
    {
        parent::__construct(); // Inicializa o PDO na classe base
        $this->favoriteService = new FavoriteService($this->pdo);
        $this->authService = new AuthService($this->pdo);
    }

    public function index()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? getallheaders()['Authorization'] ?? null;

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(['message' => 'Token não fornecido.']);
            return;
        }

        $userId = $this->authService->getUserIdByToken($authHeader);

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['message' => 'Token inválido ou expirado.']);
            return;
        }

        $favorites = $this->favoriteService->getFavoritesByUser($userId);

        return json_encode(['favorites' => $favorites]);
    }




    public function add()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Pegar o token do cabeçalho Authorization
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? getallheaders()['Authorization'] ?? null;
        $token = str_replace('Bearer ', '', $authHeader);

        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(['message' => 'Token não fornecido.']);
            return;
        }

        // Obter o user_id pelo token
        $userId = $this->authService->getUserIdByToken($token);

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['message' => 'Token inválido ou expirado.']);
            return;
        }

        $movieId = $data['movie_id'] ?? null;

        if (!$movieId) {
            http_response_code(400);
            echo json_encode(['message' => 'ID do filme é obrigatório.']);
            return;
        }

        $this->favoriteService->addFavorite($userId, $movieId);
        echo json_encode(['message' => 'Filme favoritado com sucesso!']);
    }

    public function remove($movieId)
    {

        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? getallheaders()['Authorization'] ?? null;
        $token = str_replace('Bearer ', '', $authHeader);
        $userId = $this->authService->getUserIdByToken($token);


        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(['message' => 'Token não fornecido.']);
            return;
        }

        // Obter o user_id pelo token

        $data = json_decode(file_get_contents('php://input'), true);



        if (!$movieId) {
            http_response_code(400);
            echo json_encode(['message' => 'ID do filme é obrigatório.']);
            return;
        }

        $this->favoriteService->removeFavorite($userId, $movieId);
        echo json_encode(['message' => 'Filme removido dos favoritos.']);
    }

    public function list()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? getallheaders()['Authorization'] ?? null;
        $token = str_replace('Bearer ', '', $authHeader);


        if (!$token) {
            http_response_code(401);
            echo json_encode(['message' => 'Token não fornecido.']);
            return;
        }

        $userId = $this->authService->getUserIdByToken($token);

        $favorites = $this->favoriteService->getFavorites($userId);
        echo json_encode(['favorites' => $favorites]);
    }
}
