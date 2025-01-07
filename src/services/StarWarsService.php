<?php

namespace MeuProjeto\Services;

use Redis;

class StarWarsService
{
    protected $redis;
    protected $redisAvailable = false; // Flag para verificar se o Redis está disponível

    public function __construct()
    {
        try {


            $this->redis = new Redis();
            $this->redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
            $this->redisAvailable = true; // Redis está disponível
        } catch (\RedisException $e) {
            // Caso o Redis falhe, log ou mensagem
            error_log('Erro ao conectar ao Redis: ' . $e->getMessage());
        }
    }

    public function all()
    {
        $cacheKey = 'movies_list';

        // Verificar se o Redis está disponível e possui os dados no cache
        if ($this->redisAvailable && $this->redis->exists($cacheKey)) {
            return json_decode($this->redis->get($cacheKey), true);
        }

        // Caso o Redis não esteja disponível ou o cache esteja vazio, busque na API
        $response = file_get_contents('https://www.swapi.tech/api/films');
        $movies = json_decode($response, true)['result'];

        // Se o Redis estiver disponível, armazene os filmes no cache por 1 hora
        if ($this->redisAvailable) {
            $this->redis->set($cacheKey, json_encode($movies));
            $this->redis->expire($cacheKey, 3600);
        }

        return $movies;
    }

    public function show($id)
    {
        $cacheKey = "movie_$id";

        // Verificar se o Redis está disponível e possui o dado no cache
        if ($this->redisAvailable && $this->redis->exists($cacheKey)) {
            return json_decode($this->redis->get($cacheKey), true);
        }

        // Caso o Redis não esteja disponível ou o cache esteja vazio, busque na API
        $response = file_get_contents("https://www.swapi.tech/api/films/$id");
        $movie = json_decode($response, true)['result']['properties'];

        // Se o Redis estiver disponível, armazene o filme no cache por 1 hora
        if ($this->redisAvailable) {
            $this->redis->set($cacheKey, json_encode($movie));
            $this->redis->expire($cacheKey, 3600);
        }

        return $movie;
    }
}
