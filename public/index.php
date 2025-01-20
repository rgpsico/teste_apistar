<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Jenssegers\Blade\Blade;
use MeuProjeto\Config\DatabaseConfig;
use MeuProjeto\Exceptions\DatabaseConnectionException;

require_once  '../src/Helpers/helpers.php';

require_once __DIR__ . '/../config/database.php';

$views = __DIR__ . '/../src/Views';
$cache = __DIR__ . '/../cache';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$GLOBALS['blade'] = new Blade($views, $cache);


try {
    $pdo = DatabaseConfig::connect('mysql');
} catch (DatabaseConnectionException $e) {
    http_response_code($e->getCode());
    echo view('errors.exception', ['message' => $e->getMessage()]);
    exit;
} catch (\Exception $e) {
    http_response_code(500);
    echo view('errors.exception', ['message' => 'Um erro inesperado ocorreu.']);
    exit;
}
require '../router/web.php';
