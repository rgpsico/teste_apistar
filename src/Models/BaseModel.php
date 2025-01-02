<?php

namespace MeuProjeto\Models;

use MeuProjeto\Config\DatabaseConfig;
use PDO;

class BaseModel
{
    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = DatabaseConfig::connect('mysql');
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasMany($relatedModel, $foreignKey, $localKey)
    {
        $relatedInstance = new $relatedModel();
        $stmt = $this->pdo->prepare("SELECT * FROM {$relatedInstance->table} WHERE {$foreignKey} = :localKey");
        $stmt->bindParam(':localKey', $this->{$localKey});
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function belongsTo($relatedModel, $foreignKey, $ownerKey)
    {
        $relatedInstance = new $relatedModel();
        $stmt = $this->pdo->prepare("SELECT * FROM {$relatedInstance->table} WHERE {$ownerKey} = :foreignKey");
        $stmt->bindParam(':foreignKey', $this->{$foreignKey});
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
