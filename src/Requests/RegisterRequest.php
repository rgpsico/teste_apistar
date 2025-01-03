<?php

namespace MeuProjeto\Requests;

use MeuProjeto\Validation\Validator;

class RegisterRequest
{
    protected $data;
    protected $pdo;

    public function __construct($data, $pdo)
    {
        $this->data = $data;
        $this->pdo = $pdo;
    }

    public function validate()
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|min:3|max:50',
            'password' => 'required|min:6',
        ];

        $validator = new Validator($this->data, $rules, $this->pdo);

        if (!$validator->validate()) {
            return $validator->getErrors();
        }

        return null;
    }
}
