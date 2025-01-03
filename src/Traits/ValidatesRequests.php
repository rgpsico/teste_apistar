<?php

namespace MeuProjeto\Traits;

use MeuProjeto\Requests\RegisterRequest;

trait ValidatesRequests
{
    /**
     * Método genérico para executar validações
     *
     * @param string $requestClass - Classe da validação (ex: RegisterRequest)
     * @param array $data - Dados a serem validados
     * @param mixed $pdo - Conexão PDO, se necessário
     * @return void
     */
    public function validateWith($requestClass, $data, $pdo = null)
    {
        $request = new $requestClass($data, $pdo);
        $errors = $request->validate();

        if ($errors) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Erro de validação.',
                'errors' => $errors,
            ]);
            exit;
        }
    }
}
