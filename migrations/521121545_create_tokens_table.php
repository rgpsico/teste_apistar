<?php

return function ($pdo) {
    $blueprint = new Blueprint('tokens');
    $blueprint->id();
    $blueprint->integer('user_id');
    $blueprint->string('token');
    $blueprint->customTimestamp('expires_at', true); // expires_at pode ser nulo
    $blueprint->timestamps(); // Adiciona created_at e updated_at com as correções

    $pdo->exec($blueprint->build());
    echo "Tabela 'tokens' criada com sucesso.\n";
};
