<?php

namespace App\DB;

use PDO;
use PDOException;

class Connection extends PDO
{
    private $stmt;

    public function __construct(string $dbname,string $driver = "mysql",string $host = "localhost",int $port = 3306, $username = null, $password = null, $options = null)
    {
        try{
            parent::__construct($driver.":host=".$host.":".$port.";dbname=".$dbname, $username, $password, $options);
            $this->setAttribute(PDO::ATTR_ERRMODE,	PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            echo $e->getMessage();
            print("Erreur de connection<br>");
        }
    }

    public	function executeQuery(string $query, array $parameters = []) :bool
    {
        $this->stmt =parent::prepare($query);
        foreach ($parameters as	$name => $value){
            $this->stmt->bindValue($name,$value[0],$value[1]);
        }
        return	$this->stmt->execute();
    }

    public function getResults(): array
    {
        return	$this->stmt->fetchall();
    }
}