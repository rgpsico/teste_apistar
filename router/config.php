<?php

use MeuProjeto\Config\DatabaseConfig;
use MeuProjeto\Middleware\LogMiddleware;

// Obtenha o método HTTP e a URI da requisição
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);



// Certifique-se de que $pdo está disponível no escopo
$pdo = DatabaseConfig::connect('mysql');

// Processar a rota
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "Página não encontrada!";
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo "Método não permitido!";
        break;

    case FastRoute\Dispatcher::FOUND:
        [$controllerClass, $method] = $routeInfo[1];
        $vars = $routeInfo[2]; // Parâmetros da rota

        // Passar o $pdo para o controlador, caso necessário
        if ($controllerClass === MeuProjeto\Controllers\AuthController::class) {
            $controller = new $controllerClass($pdo);
        } else {
            $controller = new $controllerClass();
        }

        // Chamar o método do controlador com os parâmetros
        call_user_func_array([$controller, $method], $vars);
        break;
}
