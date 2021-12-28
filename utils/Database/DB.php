<?php

namespace Utils\Database;

use PDO;
use PDOStatement;

class DB extends PDO
{
    private PDOStatement|false $stmt;

    public function __construct($dsn, $username = null, $password = null, $options = null)
    {
        parent::__construct($dsn, $username, $password, $options);
    }

    public function executeQuery(string $query, array $parameters = []):bool
    {
        $this->stmt = parent::prepare($query);
        foreach ($parameters as $name => $value){
            $this->stmt->bindValue($name,$value[0],$value[1]);
        }
        return $this->stmt->execute();
    }

    public function getResults():array
    {
        return $this->stmt->fetchAll();
    }
}