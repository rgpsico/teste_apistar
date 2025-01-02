<?php

namespace MeuProjeto\Providers;

use Jenssegers\Blade\Blade;

class BladeServiceProvider extends ServiceProvider
{
    public function register()
    {
        global $blade;

        echo "Registrando BladeServiceProvider...\n";
        $views = __DIR__ . '/../../src/Views';
        $cache = __DIR__ . '/../../storage/cache';



        $GLOBALS['blade'] = new Blade($views, $cache);
        echo "Blade registrado com sucesso!\n";
    }

    public function boot()
    {
        echo "BladeServiceProvider inicializado.\n";
    }
}
