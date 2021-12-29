<?php

namespace Utils\Database\Gateway;

use App\Model\Post;
use PDO;

class PostGateway extends Gateway
{
    public function find(int $id): ?Post
    {
        $query = "select * from Post where id=:id";
        $this->con->executeQuery($query,[
            ":id"=>[$id,PDO::PARAM_INT]
        ]);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $post = new Post();
            $post->setDescription($result["description"]);
            $post->setTitle($result["title"]);
            $post->setId($result["id"]);
            return $post;
        }
        return null;
    }

    public function findAll():array
    {
        $query = "select * from Post";
        $this->con->executeQuery($query);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $post = new Post();
            $post->setDescription($result["description"]);
            $post->setTitle($result["title"]);
            $post->setId($result["id"]);
            $posts[] = $post;
        }
        return $posts ?? [];
    }

    public function insert(Post $post): bool
    {
        $query = "insert into Post(title, description) VALUES(:title,:description)";
        return $this->con->executeQuery($query,[
            ":title"=>[$post->getTitle(),PDO::PARAM_STR],
            ":description"=>[$post->getDescription(),PDO::PARAM_STR]
        ]);
    }

    public function remove(Post $post){
        $query = "delete from Post where :id";
        $this->con->executeQuery($query,[
            ":id"=>[$post->getId(),PDO::PARAM_INT]
        ]);
    }

    public function update(Post $post){
        $query = "update Post set title=:title,description=:description where id=:id";
        $this->con->executeQuery($query,[
            ":title"=>[$post->getTitle(),PDO::PARAM_STR],
            ":description"=>[$post->getDescription(),PDO::PARAM_STR],
            ":id"=>[$post->getId(),PDO::PARAM_INT]
        ]);
    }
}