<?php

namespace Utils\Database\Gateway;

use App\Model\Post;
use App\Model\Review;
use PDO;
use Utils\Exception\DatabaseException;

class ReviewGateway extends Gateway
{
    public function find(int $id): ?Review
    {
        $query = "select * from Review where id=:id";
        $this->con->executeQuery($query,[
            ":id"=>[$id,PDO::PARAM_INT]
        ]);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $review = new Review();
            $review->setUsername($result["username"]);
            $review->setComment($result["comment"]);
            $review->setPost($result["post"]);
            $review->setId($result["id"]);
            return $review;
        }
        return null;
    }

    public function findByPost(Post $post):array
    {
        $query = "select * from Review where post=:post";
        $this->con->executeQuery($query,[
            ":post"=>[$post->getId(),PDO::PARAM_INT]
        ]);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $review = new Review();
            $review->setUsername($result["username"]);
            $review->setComment($result["comment"]);
            $review->setPost($result["post"]);
            $review->setId($result["id"]);
            $reviews[] = $review;
        }
        return $reviews ?? [];
    }

    /**
     * @param Review $review
     * @throws DatabaseException
     */
    public function insert(Review $review)
    {
        $query = "insert into Review(username, comment, post) VALUES(:username,:comment,:post)";
        $req = $this->con->executeQuery($query,[
            ":username"=>[$review->getUsername(),PDO::PARAM_STR],
            ":comment"=>[$review->getComment(),PDO::PARAM_STR],
            ":post"=>[$review->getPost(),PDO::PARAM_INT]
        ]);
        if(!$req)throw new DatabaseException("Insert error");
    }

    public function remove(Review $review){
        $query = "delete from Review where id=:id";
        $this->con->executeQuery($query,[
            ":id"=>[$review->getId(),PDO::PARAM_INT]
        ]);
    }

    public function create()
    {
        $query = "
            create table Review
            (
                id       int auto_increment
                    primary key,
                username varchar(255) not null,
                comment  longtext     not null,
                post     int          null,
                constraint FK_5BC96BF05A8A6C8D
                    foreign key (post) references Post (id)
            )
                collate = utf8_unicode_ci;
            
            create index IDX_5BC96BF05A8A6C8D
            on Review (post);
        ";
        $this->con->executeQuery($query);
    }
}