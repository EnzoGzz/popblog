<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Utils\Validation;
use Utils\Exception\ValidationException;

class AdminController extends Controller
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        session_start();
    }

    public function connexionVue(){
        $this->render("Connexion");
    }

    public function post()
    {
        $em_post = $this->em->getRepository(Post::class);
        $posts = $em_post->findAll();
        $this->render('ListPost',[
            "posts" => $posts
        ]);
    }

    public function connexion()
    {
        try{
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? "";

            Validation::require($username);
            Validation::maxChar($username,255);
            Validation::require($password);
            Validation::maxChar($password,255);



            $password = password_hash($password, PASSWORD_DEFAULT);
            $em_user = $this->em->getRepository(User::class);
            $user = $em_user->findOneBy(["username"=>$username]);
            if($user != NULL){
                if($password === $user->getPassword()){
                    // create session and redirection
                }else{
                    throw new Exception("Invalid password");
                }
            }else{
                throw new Exception("Invalid username");
            }
        }catch (Exception $e){
            $this->errors[] = "Invalid password or username";
        } finally {
            $this->render("",[

            ]);
        }

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