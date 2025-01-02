<?php

use Jenssegers\Blade\Blade;

$views = __DIR__ . '/../src/Views';  // Pasta onde estão as Views
$cache = __DIR__ . '/../cache';     // Pasta para os arquivos cacheados

return new Blade($views, $cache);
