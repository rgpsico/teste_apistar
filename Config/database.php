<?php

namespace MeuProjeto\Config;

use Exception;
use MeuProjeto\Exceptions\DatabaseConnectionException;
use PDO;
use PDOException;

class DatabaseConfig
{
    protected static $connections = [];

    /**
     * Configurar a conexão com o banco de dados.
     * @param string $type - Tipo do banco de dados (mysql, pgsql, etc.)
     * @return PDO
     * @throws Exception
     */
    public static function connect($type = 'mysql')
    {
        if (isset(self::$connections[$type])) {
            return self::$connections[$type];
        }

        switch ($type) {
            case 'mysql':
                $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4";
                $username = $_ENV['DB_USERNAME'];
                $password = $_ENV['DB_PASSWORD'];
                break;

            case 'pgsql':
                $dsn = "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}";
                $username = $_ENV['DB_USERNAME'];
                $password = $_ENV['DB_PASSWORD'];
                break;

            default:
                throw new Exception("Tipo de banco de dados não suportado: $type");
        }

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Cachear a conexão
            self::$connections[$type] = $pdo;

            return $pdo;
        } catch (PDOException $e) {
            throw new DatabaseConnectionException(
                "Erro ao conectar ao banco de dados: " . $e->getMessage()
            );
        }
    }
}
