<?php

use FastRoute\RouteCollector;
use MeuProjeto\Controllers\Api\StarWarsControllerApi;

use function FastRoute\simpleDispatcher;


$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    // Listar todos os filmes
    $r->addRoute('GET', '/api/movies', [StarWarsControllerApi::class, 'all']);


    // Detalhes de um filme
    $r->addRoute('GET', '/movies/{id}', [StarWarsControllerApi::class, 'show']);
});

require_once 'config.php';
