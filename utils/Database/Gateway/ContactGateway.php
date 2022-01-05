<?php

namespace Utils\Database\Gateway;

use App\Model\Contact;
use PDO;
use Utils\Exception\DatabaseException;

class ContactGateway extends Gateway
{
    public function find(int $id): ?Contact
    {
        $query = "select * from Contact where id=:id";
        $this->con->executeQuery($query,[
            ":id"=>[$id,PDO::PARAM_INT]
        ]);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $contact = new Contact();
            $contact->setEmail($result["email"]);
            $contact->setMessage($result["message"]);
            $contact->setSubject($result["subject"]);
            $contact->setId($result["id"]);
            return $contact;
        }
        return null;
    }

    public function findAll():array
    {
        $query = "select * from Contact";
        $this->con->executeQuery($query);
        $results = $this->con->getResults();
        foreach ($results as $result){
            $contact = new Contact();
            $contact->setEmail($result["email"]);
            $contact->setMessage($result["message"]);
            $contact->setSubject($result["subject"]);
            $contact->setId($result["id"]);
            $contacts[] = $contact;
        }
        return $contacts ?? [];
    }

    /**
     * @param Contact $contact
     * @throws DatabaseException
     */
    public function insert(Contact $contact)
    {
        $query = "insert into Contact(email,message,subject) VALUES(:email,:message,:subject)";
        $req = $this->con->executeQuery($query,[
            ":email"=>[$contact->getEmail(),PDO::PARAM_STR],
            ":message"=>[$contact->getMessage(),PDO::PARAM_STR],
            ":subject"=>[$contact->getSubject(),PDO::PARAM_STR]
        ]);
        if(!$req)throw new DatabaseException("Insert error");
    }

    public function remove(Contact $contact){
        $query = "delete from Contact where id=:id";
        $this->con->executeQuery($query,[
            ":id"=>[$contact->getId(),PDO::PARAM_INT]
        ]);
    }

    public function create(){
        $query  = "
        create table Contact
        (
            id      int auto_increment,
            email   varchar(255) not null,
            message mediumtext   not null,
            subject tinytext     not null,
            constraint Contact_id_uindex
                unique (id)
        );
        ";
        $this->con->executeQuery($query);
    }
}