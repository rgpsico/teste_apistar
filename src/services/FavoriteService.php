<?php

namespace MeuProjeto\Services;

use PDO;

class FavoriteService
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFavoritesByUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM favorites WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFavorite($userId, $movieId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO favorites (user_id, movie_id, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$userId, $movieId]);
    }

    public function removeFavorite($userId, $movieId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND movie_id = ?");
        return $stmt->execute([$userId, $movieId]);
    }

    public function getFavorites($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM favorites WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
