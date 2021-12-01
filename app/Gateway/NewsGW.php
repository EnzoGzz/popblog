<?php

namespace App\Gateway;

use App\DB\Connection;
use App\Model\Post;
use PDO;

class NewsGW
{
    private Connection $connection;
    public	function __construct(Connection	$con)
    {
        $this->connection = $con;
    }

    public function insert(string $title, string $desc){
        $query='INSERT INTO	Post (title, description) VALUES (:title,:description)';
        $this->connection->executeQuery($query,[
            ':title' =>	[$title,PDO::PARAM_STR],
            ':description' =>	[$desc,PDO::PARAM_STR]
        ]);
    }

    public function delete(int $id){
        $query='DELETE FROM Post WHERE id=:id';
        $this->connection->executeQuery($query,[
            ':id' => [$id,PDO::PARAM_INT],
        ]);
    }

    public function update(int $id, string $title, string $desc){
        $query='UPDATE Post SET title=:title,desc=:desc WHERE id=:id';
        $this->connection->executeQuery($query,[
            ':id' => [$id,PDO::PARAM_INT],
            ':title' =>	[$title,PDO::PARAM_STR],
            ':desc' =>	[$desc,PDO::PARAM_STR]
        ]);
    }

    public function find(int $id)
    {
        $query='Select * from Post where id=:id';
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
        $query='Select * from Post';
        $this->connection->executeQuery($query);
        $results = $this->connection->getResults();
        foreach ($results as $result){
            $news[] = new Post($result["id"],$result["title"],$result["description"]);
        }
        return $news;
    }
}