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


if (!function_exists('asset')) {
    function asset(string $path)
    {
        // Caminho base para a pasta assets
        $basePath = __DIR__ . '/../../assets';

        // Combina o caminho base com o caminho solicitado
        $fullPath = realpath($basePath . '/' . $path);

        // Verifica se o arquivo existe
        if ($fullPath && file_exists($fullPath)) {
            // Retorna o caminho relativo ao diretório público
            return '/assets/' . $path;
        }

        // Retorna uma mensagem de erro ou lança uma exceção, caso o arquivo não exista
        return '/assets/' . $path; // Opcional: você pode personalizar isso
    }
}



if (!function_exists('logRequest')) {
    function logRequest($message = '', $data = [])
    {
        // Diretório para salvar os logs
        $logDirectory = __DIR__ . '/../../logs';

        // Certifique-se de que a pasta de logs existe
        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }

        // Caminho do arquivo de log
        $logFile = $logDirectory . '/requests.log';

        // Obter data e hora atual
        $date = date('Y-m-d H:i:s');

        // Criar a mensagem do log
        $logMessage = "[$date] $message\n";

        // Adicionar os dados (se houver)
        if (!empty($data)) {
            $logMessage .= json_encode($data, JSON_PRETTY_PRINT) . "\n";
        }

        // Salvar o log no arquivo
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}
