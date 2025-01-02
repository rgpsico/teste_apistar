<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Services\StarWarsService;

class StarWarsController
{
    protected $service;
    protected $blade;

    public function __construct()
    {
        $this->service = new StarWarsService();
        global $blade;
        $this->blade = $blade;
    }

    public function all()
    {
        try {
            $movies = $this->service->all();

            // Ordenar os filmes por data de lançamento
            usort($movies, function ($a, $b) {
                return strtotime($a['properties']['release_date']) - strtotime($b['properties']['release_date']);
            });

            // Renderizar a view index
            echo view('starswar.index', ['movies' => $movies]);
        } catch (\Exception $e) {
            echo "Erro ao carregar a lista de filmes: " . $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $movie = $this->service->show($id);

            // Calculando a idade do filme
            $releaseDate = new \DateTime($movie['release_date']);
            $currentDate = new \DateTime();
            $interval = $releaseDate->diff($currentDate);

            $movie['age'] = [
                'years' => $interval->y,
                'months' => $interval->m,
                'days' => $interval->d,
            ];

            // Renderizar a view show
            echo view('starswar.show', ['movie' => $movie]);
        } catch (\Exception $e) {
            echo "Erro ao carregar os detalhes do filme: " . $e->getMessage();
        }
    }
}
