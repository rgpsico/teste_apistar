<?php

return function ($pdo) {
    $blueprint = new Blueprint('tokens');
    $blueprint->id();
    $blueprint->integer('user_id');
    $blueprint->string('token', 255, false); // NOT NULL
    $blueprint->timestamps('expires_at', true); // NULLABLE
    $blueprint->timestamps(); // Inclui created_at e updated_at
    $pdo->exec($blueprint->build());
    echo "Tabela 'tokens' criada com sucesso.\n";
};
