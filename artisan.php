<?php

if ($argc < 2) {
    echo "Uso: php artisan.php make:migration NomeDaTabela\n";
    exit;
}

$command = $argv[1];
$tableName = $argv[2] ?? null;

if ($command === 'make:migration' && $tableName) {
    $timestamp = date('YmdHis');
    $filename = "migrations/{$timestamp}_create_{$tableName}_table.php";
    $content = <<<PHP
<?php

return function (\$pdo) {
    \$blueprint = new Blueprint('$tableName');
    \$blueprint->id();
    \$blueprint->timestamps();

    \$pdo->exec(\$blueprint->build());
    echo "Tabela '$tableName' criada com sucesso.\n";
};
PHP;

    file_put_contents($filename, $content);
    echo "Migration criada: $filename\n";
} else {
    echo "Comando inválido.\n";
}
