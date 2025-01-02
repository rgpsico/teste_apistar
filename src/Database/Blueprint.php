<?php
class Blueprint
{
    protected $table;
    protected $columns = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * Adiciona uma coluna ID auto incrementável como chave primária.
     */
    public function id()
    {
        $this->columns[] = 'id INT AUTO_INCREMENT PRIMARY KEY';
    }

    /**
     * Adiciona uma coluna do tipo VARCHAR.
     */
    public function string($column, $length = 255, $nullable = false)
    {
        $this->columns[] = "$column VARCHAR($length) " . ($nullable ? "NULL" : "NOT NULL");
    }

    /**
     * Adiciona uma coluna do tipo TEXT.
     */
    public function text($column, $nullable = false)
    {
        $this->columns[] = "$column TEXT " . ($nullable ? "NULL" : "NOT NULL");
    }

    /**
     * Adiciona uma coluna do tipo INTEGER.
     */
    public function integer($column, $nullable = false)
    {
        $this->columns[] = "$column INT " . ($nullable ? "NULL" : "NOT NULL");
    }

    /**
     * Adiciona as colunas padrão created_at e updated_at.
     */
    public function timestamps()
    {
        // Define created_at com DEFAULT CURRENT_TIMESTAMP
        $this->columns[] = 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP';

        // Define updated_at sem DEFAULT ou ON UPDATE, permitindo valores nulos
        $this->columns[] = 'updated_at TIMESTAMP NULL';
    }

    /**
     * Gera o comando SQL para criar a tabela.
     */
    public function build()
    {
        return "CREATE TABLE {$this->table} (" . implode(', ', $this->columns) . ");";
    }
}
