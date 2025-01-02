<?php

namespace MeuProjeto\Config;

use Jenssegers\Blade\Blade;

class BladeFactory
{
    private static $blade;

    public static function getInstance()
    {
        if (!self::$blade) {
            $views = __DIR__ . '/../../src/Views'; // Caminho das views
            $cache = __DIR__ . '/../../cache';    // Caminho do cache
            self::$blade = new Blade($views, $cache);
        }

        return self::$blade;
    }
}
