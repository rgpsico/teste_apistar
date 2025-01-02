<?php

require __DIR__ . '/vendor/autoload.php';

function criarModel($nome)
{
    $nomeModel = ucfirst($nome);

    $pastaModels = __DIR__ . '/src/Models';

    // Cria a pasta, se não existir
    if (!is_dir($pastaModels)) mkdir($pastaModels, 0755, true);

    // Conteúdo do Model
    $conteudoModel = <<<PHP
<?php

namespace MeuProjeto\Models;

class {$nomeModel}
{
    // Atributos do modelo

    protected \$table = '{$nomeModel}';
    
    // Métodos relacionados ao modelo
}
PHP;

    file_put_contents("$pastaModels/$nomeModel.php", $conteudoModel);

    echo "Model '$nomeModel' criado com sucesso em $pastaModels/$nomeModel.php\n";
}

// Verificar argumentos do terminal
$args = $argv;

if (count($args) < 2) {
    echo "Uso: php criar.php criar:model NomeModel\n";
    exit;
}

$command = $args[1];

if ($command === 'criar:model') {
    $nome = $args[2] ?? null;
    if (!$nome) {
        echo "Erro: Nome do model não especificado.\n";
        exit;
    }
    criarModel($nome);
} else {
    echo "Comando desconhecido.\n";
}


function criarController($nome, $criarModel = false)
{
    $nomeController = ucfirst($nome) . 'Controller';
    $nomeService = ucfirst($nome) . 'Service';
    $nomeModel = ucfirst($nome);

    $pastaControllers = __DIR__ . '/src/Controllers';
    $pastaServices = __DIR__ . '/src/Services';
    $pastaModels = __DIR__ . '/src/Models';

    // Cria as pastas, se não existirem
    if (!is_dir($pastaControllers)) mkdir($pastaControllers, 0755, true);
    if (!is_dir($pastaServices)) mkdir($pastaServices, 0755, true);
    if ($criarModel && !is_dir($pastaModels)) mkdir($pastaModels, 0755, true);

    // Conteúdo do Controller
    $conteudoController = <<<PHP
<?php

namespace MeuProjeto\Controllers;

use MeuProjeto\Services\\{$nomeService};

class {$nomeController}
{
    protected \${$nome}Service;

    public function __construct()
    {
        \$this->{$nome}Service = new {$nomeService}();
    }

    public function index()
    {
        // Lógica para listar
    }

    public function show(\$id)
    {
        // Lógica para exibir detalhes
    }

    public function create()
    {
        // Lógica para criar
    }

    public function update(\$id)
    {
        // Lógica para atualizar
    }

    public function delete(\$id)
    {
        // Lógica para deletar
    }
}
PHP;

    file_put_contents("$pastaControllers/$nomeController.php", $conteudoController);

    // Conteúdo do Service
    $conteudoService = <<<PHP
<?php

namespace MeuProjeto\Services;

class {$nomeService}
{
    public function getAll()
    {
        // Lógica para obter todos os registros
    }

    public function getById(\$id)
    {
        // Lógica para obter um registro por ID
    }

    public function create(\$data)
    {
        // Lógica para criar um registro
    }

    public function update(\$id, \$data)
    {
        // Lógica para atualizar um registro
    }

    public function delete(\$id)
    {
        // Lógica para deletar um registro
    }
}
PHP;

    file_put_contents("$pastaServices/$nomeService.php", $conteudoService);

    // Conteúdo do Model (opcional)
    if ($criarModel) {
        $conteudoModel = <<<PHP
<?php

namespace MeuProjeto\Models;

class {$nomeModel}
{
    // Definição do modelo (atributos e métodos)
}
PHP;
        file_put_contents("$pastaModels/$nomeModel.php", $conteudoModel);
    }

    echo "Arquivos criados com sucesso:\n";
    echo "- $nomeController\n";
    echo "- $nomeService\n";
    if ($criarModel) echo "- $nomeModel\n";
}

// Verificar argumentos do terminal
$args = $argv;
if (count($args) < 2) {
    echo "Uso: php criar.php criar:controller NomeController [-m NomeModel]\n";
    exit;
}

$command = $args[1];
if ($command === 'criar:controller') {
    $nome = $args[2] ?? null;
    if (!$nome) {
        echo "Erro: Nome do controller não especificado.\n";
        exit;
    }

    $criarModel = in_array('-m', $args) ? true : false;
    criarController($nome, $criarModel);
} else {
    echo "Comando desconhecido.\n";
}
