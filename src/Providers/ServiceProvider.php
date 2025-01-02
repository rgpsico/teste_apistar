<?php

namespace MeuProjeto\Providers;

abstract class ServiceProvider
{
    /**
     * Método para registrar serviços (implementado em classes específicas).
     */
    abstract public function register();

    /**
     * Método opcional para executar ações durante a inicialização.
     */
    public function boot()
    {
        // Opcional: Inicialização após o registro
    }
}
