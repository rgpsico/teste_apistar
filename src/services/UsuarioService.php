<?php

namespace MeuProjeto\Services;

use PDO;

class UsuarioService
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Retorna todos os usuários e seus favoritos
    public function getAllUsersWithFavorites()
    {
        $stmt = $this->pdo->prepare("
            SELECT users.*, favorites.movie_id 
            FROM users
            LEFT JOIN favorites ON users.id = favorites.user_id
        ");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

        // Estruturar os favoritos
        $users = [];
        foreach ($result as $userId => $userData) {
            $user = $userData[0]; // Dados do usuário
            $user['favorites'] = array_column($userData, 'movie_id'); // Favoritos do usuário
            $users[] = $user;
        }

        return $users;
    }

    // Retorna um usuário específico pelo ID
    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Retorna os favoritos de um usuário específico
    public function getFavoritesByUserId($userId)
    {
        $stmt = $this->pdo->prepare("SELECT movie_id FROM favorites WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
