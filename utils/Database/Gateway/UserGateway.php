<?php

namespace Utils\Database\Gateway;

use App\Model\User;
use PDO;

class UserGateway extends Gateway
{

    public function find(int $id): ?User
    {
        $query = "select * from User where id=:id";
        $this->con->executeQuery($query,[
           ":id"=>[$id,PDO::PARAM_INT]
        ]);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $user = new User();
            $user->setUsername($result["username"]);
            $user->setPassword($result["password"]);
            $user->setId($result["id"]);
            return $user;
        }
        return null;
    }


    public function findOneByUsername(string $username): ?User
    {
        $query = "select * from User where username=:username LIMIT 1";
        $this->con->executeQuery($query,[
            ":username"=>[$username,PDO::PARAM_INT]
        ]);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $user = new User();
            $user->setUsername($result["username"]);
            $user->setPassword($result["password"]);
            $user->setId($result["id"]);
            return $user;
        }
        return null;
    }
}