<?php

use Jenssegers\Blade\Blade;

if (!function_exists('view')) {
    function view(string $view, array $data = [])
    {
        // Caminhos corretos das views e do cache
        $views = __DIR__ . '/../Views'; // Pasta onde estão as views
        $cache = __DIR__ . '/../../cache'; // Pasta do cache

        // Criar uma instância do Blade
        $blade = new Blade($views, $cache);

        // Renderizar a view
        return $blade->render($view, $data);
    }
}
