<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Services\PokemonService;

class PokemonController
{
    protected $apiService;

    public function __construct()
    {
        $this->apiService = new PokemonService();
    }

    // Listar todos os Pokémon
    public function index()
    {
        $pokemons = $this->apiService->getPokemons(20, 0);

        // Usar a função view para renderizar a página
        echo view('pokemons.home', [
            'titulo' => 'Lista de Pokémon',
            'pokemons' => $pokemons['results'],
        ]);
    }

    // Exibir detalhes de um Pokémon
    public function show($id)
    {
        $pokemon = $this->apiService->getPokemon($id);

        echo view('pokemons.show', [
            'pokemon' => $pokemon,
        ]);
    }
}
