<?php

namespace Utils\Database;

use Utils\Database\Gateway\ContactGateway;
use Utils\Database\Gateway\DatabaseGateway;
use Utils\Database\Gateway\PostGateway;
use Utils\Database\Gateway\ReviewGateway;
use Utils\Database\Gateway\UserGateway;

class DatabaseCreator
{
    private DB $con;

    public function __construct(DB $con)
    {
        $this->con = $con;
    }

    public function makeDatabase(){
        $db_gateway = new DatabaseGateway($this->con);
        $db_gateway->create();
    }

    public function makeUser(){
        $em_user = new UserGateway($this->con);
        $em_user->create();
        $em_user->insert("test",password_hash("test",PASSWORD_DEFAULT));
    }

    public function makeContact(){
        $em_contact = new ContactGateway($this->con);
        $em_contact->create();
    }

    public function makePost(){
        $em_post = new PostGateway($this->con);
        $em_post->create();
    }

    public function makeReview(){
        $em_review = new ReviewGateway($this->con);
        $em_review->create();
    }
}