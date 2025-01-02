<?php

return function ($pdo) {

    // Adicionar colunas
    $blueprint = new Blueprint('logs');
    $blueprint->id();
    $blueprint->string('endpoint');
    $blueprint->string('method', 10);
    $blueprint->integer('response_status');
    $blueprint->text('message');
    $blueprint->timestamps();

    $sql = $blueprint->build();

    // Executar o comando SQL gerado
    $pdo->exec($blueprint->build());
    echo "Tabela 'logs' criada com sucesso.\n";
};
