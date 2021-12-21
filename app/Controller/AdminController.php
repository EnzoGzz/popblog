<?php

namespace App\Controller;

use App\Model\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Utils\Validation;
use Utils\Exception\ValidationException;

class AdminController extends Controller
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
    }


    public function post()
    {
        $em_post = $this->em->getRepository(Post::class);
        $posts = $em_post->findAll();
        $this->render('BlogAdmin',[
            "posts" => $posts
        ]);
    }



    public function insertPost()
    {
        $title = $_POST['title'] ?? "";
        try {
            Validation::require($title);
            Validation::maxChar($title, 255);
        } catch (ValidationException $e) {

        }
        $desc = $_POST['description'] ?? "";
        try {
            Validation::require($desc);
            Validation::maxChar($desc, 2000);
        } catch (ValidationException $e) {

        }

        $post = new Post();
        $post->setTitle($title);
        $post->setDescription($desc);
        try {
            $this->em->persist($post);
            $this->em->flush();
        } catch (OptimisticLockException | ORMException $e) {
        }

        $this->redirect("/post");
    }

    public function logout(){
        session_destroy();
        header("Location: /");
    }

    public function deletePost($id)
    {
        try{
            Validation::int($id);
        }catch (ValidationException $e){

        }

        try{
            $em_post = $this->em->getRepository(Post::class);
            $post = $em_post->find($id);
            $this->em->remove($post);
        }catch (ORMException $e) {
            //Erreur
        }
    }
}