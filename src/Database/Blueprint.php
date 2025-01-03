<?php
class Blueprint
{
    protected $table;
    protected $columns = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function id()
    {
        $this->columns[] = 'id INT AUTO_INCREMENT PRIMARY KEY';
    }

    public function string($column, $length = 255, $nullable = false)
    {
        $this->columns[] = "$column VARCHAR($length) " . ($nullable ? "NULL" : "NOT NULL");
    }

    public function text($column, $nullable = false)
    {
        $this->columns[] = "$column TEXT " . ($nullable ? "NULL" : "NOT NULL");
    }

    public function integer($column, $nullable = false)
    {
        $this->columns[] = "$column INT " . ($nullable ? "NULL" : "NOT NULL");
    }

    public function customTimestamp($column, $nullable = false)
    {
        $this->columns[] = "$column TIMESTAMP " . ($nullable ? "NULL" : "NOT NULL");
    }

    public function timestamps()
    {
        $this->columns[] = 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'; // Apenas created_at usa CURRENT_TIMESTAMP
        $this->columns[] = 'updated_at TIMESTAMP NULL'; // updated_at permite valores nulos
    }


    public function build()
    {
        return "CREATE TABLE {$this->table} (" . implode(', ', $this->columns) . ");";
    }
}
