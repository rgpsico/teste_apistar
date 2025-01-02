<?php

return function ($pdo) {
    $blueprint = new Blueprint('favorites');
    $blueprint->id();
    $blueprint->integer('user_id');
    $blueprint->string('movie_id');
    $blueprint->timestamps();

    $pdo->exec($blueprint->build());
    echo "Tabela 'favorites' criada com sucesso.\n";
};
