<?php

namespace MeuProjeto\Services;

use GuzzleHttp\Client;

class PokemonService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://pokeapi.co/api/v2/',
            'timeout'  => 5.0,
        ]);
    }

    // Buscar lista de Pokémon com paginação
    public function getPokemons($limit = 20, $offset = 0)
    {
        $response = $this->client->get("pokemon", [
            'query' => [
                'limit' => $limit,
                'offset' => $offset,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    // Buscar detalhes de um Pokémon por nome ou ID
    public function getPokemon($nameOrId)
    {
        $response = $this->client->get("pokemon/$nameOrId");
        return json_decode($response->getBody()->getContents(), true);
    }
}
