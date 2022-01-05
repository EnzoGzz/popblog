<?php

namespace Utils\Database\Gateway;

class DatabaseGateway extends Gateway
{
    public function create(){
        $query = "CREATE DATABASE popblog";
        $this->con->executeQuery($query);
    }
}