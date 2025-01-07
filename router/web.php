<?php

use FastRoute\RouteCollector;
use MeuProjeto\Controllers\Api\StarWarsControllerApi;
use MeuProjeto\Controllers\AuthController;
use MeuProjeto\Controllers\FavoriteController;
use MeuProjeto\Controllers\HomeController;
use MeuProjeto\Controllers\StarWarsController;
use MeuProjeto\Controllers\PokemonController;

use function FastRoute\simpleDispatcher;

// Configure as rotas em uma única chamada ao simpleDispatcher
$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    // Rotas Pokémon
    $r->addRoute('GET', '/', [HomeController::class, 'index']); // Lista Pokémon


    $r->addRoute('GET', '/pokemon', [PokemonController::class, 'index']); // Lista Pokémon
    $r->addRoute('GET', '/pokemon/show/{id}', [PokemonController::class, 'show']); // Detalhes de Pokémon
    $r->addRoute('GET', '/pokemon/delete/{id}', [PokemonController::class, 'delete']); // Excluir Pokémon

    // Rotas Star Wars
    $r->addRoute('GET', '/movies', [StarWarsController::class, 'all']);
    $r->addRoute('GET', '/movies/{id}', [StarWarsController::class, 'show']);


    $r->addRoute('GET', '/api/movies', [StarWarsControllerApi::class, 'all']);
    $r->addRoute('GET', '/api/movies/{id}', [StarWarsControllerApi::class, 'show']);


    $r->addRoute('POST', '/auth/user', [AuthController::class, 'user']);
    $r->addRoute('POST', '/auth/register', [AuthController::class, 'register']);
    $r->addRoute('POST', '/auth/login', [AuthController::class, 'login']);
    $r->addRoute('POST', '/auth/logout', [AuthController::class, 'logout']);



    $r->addRoute('GET', '/favorites/all', [FavoriteController::class, 'index']);
    $r->addRoute('POST', '/favorites', [FavoriteController::class, 'add']); // Adicionar favorito
    $r->addRoute('DELETE', '/favorites/{id}', [FavoriteController::class, 'remove']); // Remover favorito
    $r->addRoute('GET', '/favorites', [FavoriteController::class, 'list']); // Listar favoritos
});

// Inclui a lógica para processar as rotas
require_once 'config.php';
