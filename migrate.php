<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use MeuProjeto\Config\DatabaseConfig;

require_once __DIR__ . '/Config/database.php';
require_once __DIR__ . '/src/Database/Blueprint.php';

// Carregar variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // Conectar ao banco de dados
    $pdo = DatabaseConfig::connect('mysql');
    echo "Conexão bem-sucedida.\n";

    // Criar a tabela de controle de migrations, se não existir
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Rodar todas as migrations
    foreach (glob(__DIR__ . '/migrations/*.php') as $file) {
        $migrationName = basename($file); // Nome do arquivo da migration

        // Verificar se a migration já foi executada
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration_name = ?");
        $stmt->execute([$migrationName]);
        $alreadyExecuted = $stmt->fetchColumn();

        if ($alreadyExecuted > 0) {
            echo "Migration '{$migrationName}' já foi executada. Pulando...\n";
            continue;
        }

        // Executar a migration
        $migration = require $file;
        $migration($pdo);

        // Registrar a execução da migration na tabela
        $stmt = $pdo->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
        $stmt->execute([$migrationName]);

        echo "Migration '{$migrationName}' executada com sucesso.\n";
    }

    echo "Todas as migrations foram executadas com sucesso.\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
