<?php

use MeuProjeto\Config\DatabaseConfig;
use MeuProjeto\Middleware\LogMiddleware;

$logMiddleware = new LogMiddleware($pdo);

// Obtenha o método HTTP e a URI da requisição
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);


logRequest('Nova requisição recebida', [
    'method' => $httpMethod,
    'uri' => $uri,
    'headers' => getallheaders(),
    'body' => file_get_contents('php://input'),
]);

// Certifique-se de que $pdo está disponível no escopo
$pdo = DatabaseConfig::connect('mysql');

// Processar a rota
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "Página não encontrada!";
        $logMiddleware->handle($uri, $httpMethod, 404, 'Página não encontrada');
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo "Método não permitido!";
        $logMiddleware->handle($uri, $httpMethod, 405, 'Método não permitido');
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

        // Registrar o log antes de executar o método
        try {
            call_user_func_array([$controller, $method], $vars);
            $logMiddleware->handle($uri, $httpMethod, 200, 'Requisição processada com sucesso');
        } catch (\Exception $e) {
            $logMiddleware->handle($uri, $httpMethod, 500, $e->getMessage());
            http_response_code(500);
            echo "Erro interno do servidor!";
        }
        break;
}
