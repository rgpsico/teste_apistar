<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Jenssegers\Blade\Blade;
use MeuProjeto\Config\DatabaseConfig;

// $redis = new Redis();
// $redis->connect('127.0.0.1', 6379);
// $redis->set('test', 'Conexão bem-sucedida!');
// echo $redis->get('test');


require_once  '../src/Helpers/helpers.php';

require_once __DIR__ . '/../config/database.php';

$views = __DIR__ . '/../src/Views';
$cache = __DIR__ . '/../cache';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$GLOBALS['blade'] = new Blade($views, $cache);
$pdo = DatabaseConfig::connect('mysql');
require '../router/web.php';
