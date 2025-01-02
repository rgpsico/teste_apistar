<?php

namespace MeuProjeto\Controllers\Api;

use MeuProjeto\Services\StarWarsService;

class StarWarsControllerApi
{
    protected $service;

    public function __construct()
    {
        $this->service = new StarWarsService();
    }

    /**
     * Listar todos os filmes.
     */
    public function all()
    {
        try {
            $movies = $this->service->all();

            // Ordenar os filmes por data de lançamento
            usort($movies, function ($a, $b) {
                return strtotime($a['properties']['release_date']) - strtotime($b['properties']['release_date']);
            });

            // Retornar como JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $movies,
            ]);
        } catch (\Exception $e) {
            // Retornar erro como JSON
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Obter detalhes de um filme pelo ID.
     */
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

            // Retornar como JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $movie,
            ]);
        } catch (\Exception $e) {
            // Retornar erro como JSON
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
