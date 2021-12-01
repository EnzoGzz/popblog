<?php

namespace App\Gateway;

use App\DB\Connection;
use App\Model\News;
use PDO;

class NewsGW
{
    private Connection $connection;
    public	function __construct(Connection	$con)
    {
        $this->connection = $con;
    }

    public function insert(string $title, string $desc){
        $query='INSERT INTO	News (title, description) VALUES (:title,:description)';
        $this->connection->executeQuery($query,[
            ':title' =>	[$title,PDO::PARAM_STR],
            ':description' =>	[$desc,PDO::PARAM_STR]
        ]);
    }

    public function delete(int $id){
        $query='DELETE FROM News WHERE id=:id';
        $this->connection->executeQuery($query,[
            ':id' => [$id,PDO::PARAM_INT],
        ]);
    }

    public function update(int $id, string $title, string $desc){
        $query='UPDATE News SET title=:title,desc=:desc WHERE id=:id';
        $this->connection->executeQuery($query,[
            ':id' => [$id,PDO::PARAM_INT],
            ':title' =>	[$title,PDO::PARAM_STR],
            ':desc' =>	[$desc,PDO::PARAM_STR]
        ]);
    }

    public function find(int $id)
    {
        $query='Select * from News where id=:id';
        $this->connection->executeQuery($query,[
            ':id' => [$id,PDO::PARAM_INT],
        ]);
        $results = $this->connection->getResults();
        return $results[0];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $news = [];
        $query='Select * from News';
        $this->connection->executeQuery($query);
        $results = $this->connection->getResults();
        foreach ($results as $result){
            $news[] = new News($result["id"],$result["title"],$result["description"]);
        }
        return $news;
    }
}