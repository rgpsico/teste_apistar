<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Config\DatabaseConfig;

abstract class BaseController
{
    protected $pdo;

    public function __construct()
    {
        // Inicializar o PDO para todos os controladores que herdam BaseController
        $this->pdo = DatabaseConfig::connect('mysql');
    }
}
