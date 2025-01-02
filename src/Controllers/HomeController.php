<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Services\PokemonService;

class HomeController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new PokemonService();
    }

    public function index()
    {
        // Exemplo de uso correto: buscar o Pokémon "pikachu"
        $dados = $this->apiService->getPokemons('pikachu'); // ou use um ID como '1'


        $blade = require __DIR__ . '/../../config/blade.php';

        // Passar dados para a View
        echo $blade->render('home', [
            'titulo' => 'Meu Projeto MVC',
            'pokemon' =>   $dados,
            'mensagem' => 'AQui'
        ]);
    }
}
