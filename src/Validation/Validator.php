<?php

namespace MeuProjeto\Validation;

class Validator
{
    protected $data;
    protected $rules;
    protected $errors = [];
    protected $pdo;

    public function __construct($data, $rules, $pdo = null)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->pdo = $pdo;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;

            // Verificar se $rules é uma string antes de usar explode
            if (is_string($rules)) {
                $rules = explode('|', $rules);
            } else {
                // Adicionar erro caso as regras não estejam no formato correto
                $this->errors[$field][] = "Formato inválido para as regras do campo {$field}.";
                continue;
            }

            foreach ($rules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }

        // Retorna true se não houver erros, caso contrário, retorna false
        return empty($this->errors);
    }



    protected function applyRule($field, $value, $rule)
    {

        // Separar a regra principal e os parâmetros (se houver)
        if (strpos($rule, ':') !== false) {
            [$ruleName, $parameterString] = explode(':', $rule, 2);
            $parameters = explode(',', $parameterString);
        } else {
            $ruleName = $rule;
            $parameters = [];
        }


        switch ($ruleName) {
            case 'unique':
                if ($this->pdo) {
                    // Extraindo a tabela e a coluna do parâmetro
                    if (isset($parameters[0]) && strpos($parameters[0], ',') !== false) {
                        [$table, $dbField] = explode(',', $parameters[0], 2);
                    } else {
                        $table = 'users'; // Tabela padrão
                        $dbField = $field; // Campo padrão
                    }

                    // Verificar unicidade
                    if ($this->isNotUnique($table, $dbField, $value)) {
                        $this->addError($field, "O campo $field deve ser único.");
                    }
                }
                break;
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "O campo $field é obrigatório.");
                }
                break;




            case 'max':
                if (strlen($value) > (int)$parameters[0]) {
                    $this->addError($field, "O campo $field deve ter no máximo {$parameters[0]} caracteres.");
                }
                break;

            case 'min':
                if (strlen($value) < (int)$parameters[0]) {
                    $this->addError($field, "O campo $field deve ter no mínimo {$parameters[0]} caracteres.");
                }
                break;

            default:
                break;
        }
    }


    protected function isNotUnique($table, $dbField, $value)
    {
        // Garantir que os parâmetros sejam seguros
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $table WHERE $dbField = ?");
        $stmt->execute([$value]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }



    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }
    public function getErrors()
    {
        return $this->errors;
    }

    public function errors()
    {
        return $this->errors;
    }
}
