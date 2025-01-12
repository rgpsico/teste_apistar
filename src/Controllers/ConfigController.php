<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Config\DatabaseConfig;

class ConfigController
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseConfig::connect('mysql');
    }

    public function index()
    {
        // Renderiza a view da página de configurações
        echo view('config.index');
    }

    public function getConfig()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM configurations LIMIT 1");
            $stmt->execute();
            $config = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Retorna as configurações em JSON
            echo json_encode($config);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao buscar configurações: ' . $e->getMessage()]);
        }
    }

    public function saveConfig()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO configurations (storage, enable_logging, enable_cache) 
                VALUES (:storage, :enable_logging, :enable_cache)
                ON DUPLICATE KEY UPDATE
                storage = VALUES(storage),
                enable_logging = VALUES(enable_logging),
                enable_cache = VALUES(enable_cache)
            ");

            $stmt->execute([
                'storage' => $input['storage'],
                'enable_logging' => $input['enableLogging'] ? 1 : 0,
                'enable_cache' => $input['enableCache'] ? 1 : 0
            ]);

            http_response_code(200);
            echo json_encode(['message' => 'Configurações salvas com sucesso!']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao salvar configurações: ' . $e->getMessage()]);
        }
    }
}
