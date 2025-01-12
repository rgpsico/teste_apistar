<?php

return function ($pdo) {
    $blueprint = new Blueprint('configurations');

    // Definir colunas
    $blueprint->id(); // ID auto-incrementável como chave primária
    $blueprint->enum('storage', ['redis', 'mysql', 'none'], 'none'); // Opções para storage
    $blueprint->boolean('enable_logging', false); // Logging habilitado/desabilitado
    $blueprint->boolean('enable_cache', false); // Cache habilitado/desabilitado
    $blueprint->timestamps(); // Colunas created_at e updated_at

    // Executar a criação da tabela no banco de dados
    $pdo->exec($blueprint->build());
    echo "Tabela 'configurations' criada com sucesso.\n";
};
