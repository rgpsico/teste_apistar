<?php

return function ($pdo) {
    $blueprint = new Blueprint('users');
    $blueprint->id();
    $blueprint->string('name');
    $blueprint->string('email');
    $blueprint->string('password');
    $blueprint->timestamps();

    $pdo->exec($blueprint->build());
    echo "Tabela 'users' criada com sucesso.\n";
};
