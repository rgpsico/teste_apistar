<?php

namespace MeuProjeto\Services;

class AuthService
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
    }

    public function getUserIdByToken($token)
    {
        $stmt = $this->pdo->prepare("SELECT user_id FROM tokens WHERE token = ?");
        $stmt->execute([$token]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ? $result['user_id'] : null;
    }

    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $token = bin2hex(random_bytes(32)); // Gerar token aleatório
            $expiresAt = (new \DateTime())->modify('+1 day')->format('Y-m-d H:i:s');


            // Salvar token na tabela tokens
            $stmt = $this->pdo->prepare("INSERT INTO tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$user['id'], $token, $expiresAt]);

            return $token; // Retornar o token gerado
        }

        return null;
    }

    public function getUserByToken($token)
    {
        $stmt = $this->pdo->prepare("SELECT users.* FROM users 
            JOIN tokens ON users.id = tokens.user_id
            WHERE tokens.token = ? AND tokens.expires_at > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function logout($token)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tokens WHERE token = ?");
        $stmt->execute([$token]);
    }
}
