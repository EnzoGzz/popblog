<?php

namespace App\Controller;

use App\Model\Contact;
use App\Model\Review;
use App\Model\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Utils\Database\Gateway\ContactGateway;
use Utils\Database\Gateway\PostGateway;
use Utils\Database\Gateway\ReviewGateway;
use Utils\ModelAdmin;
use Utils\Validation;
use Utils\Exception\DatabaseException;

class AdminController extends Controller
{


    public function post()
    {
        $em_post = new PostGateway($this->con);
        $posts = $em_post->findAll();
        $this->render('BlogAdmin',[
            "posts" => $posts
        ]);
    }

    public function createPost(){
        $this->render('PostCreate');
    }

    public function insertPost()
    {
        try{
            $title = $_POST['title'] ?? "";
            try {
                Validation::require($title);
                Validation::maxChar($title, 255);
            } catch (DatabaseException $e) {
                throw new Exception("Invalid title - max 255 characters");
            }
            $desc = $_POST['description'] ?? "";
            try {
                Validation::require($desc);
                Validation::maxChar($desc, 2000);
            } catch (DatabaseException $e) {
                throw new Exception("Invalid description - max 2000 characters");
            }

            try {
                $em_post = new PostGateway($this->con);
                $post = new Post();
                $post->setTitle($title);
                $post->setDescription($desc);
                $em_post->insert($post);
            } catch (Exception $e) {
                throw new Exception("Please contact an administrator");
            }
        }catch (Exception $e){
            $this->redirect($this->route("CreatePost"),errors: $e->getMessage());
            return;
        }
        $this->redirect($this->route("AdminBlogs"));
    }

    public function showContact()
    {
        $em_post = new ContactGateway($this->con);
        $contacts = $em_post->findAll();
        $this->render('ContactAdmin',[
            "contacts" => $contacts
        ]);
    }

    public function deleteContact($id)
    {
        try{
            Validation::int($id);
            $em_contact = $this->em->getRepository(Contact::class);
            $contact = $em_contact->find($id);
            $this->em->remove($contact);
            $this->em->flush();
            $this->redirect($this->route("AdminContact"));
        }catch (Exception $e) {
            echo $e->getMessage();
            $this->redirect($this->route("error404"));
        }
    }

    public function logout(){
        ModelAdmin::logout();
        $this->redirect($this->route("Home"));
    }

    public function deletePost(int $id)
    {
        try{
            Validation::int($id);
            $em_post = new PostGateway($this->con);
            $em_comment = new ReviewGateway($this->con);
            $post = $em_post->find($id);
            if($post === null) throw new Exception("Heu beug");
            $comments = $em_comment->findByPost($post);
            foreach ($comments as $comment) {
                $em_comment->remove($comment);
            }
            $em_post->remove($post);
            $this->redirect($this->route("AdminBlogs"));
        }catch (Exception $e) {
            $this->redirect($this->route("404"));
        }
    }

    public function showPost(int $id)
    {
        try{
            Validation::int($id);
        } catch (DatabaseException $e) {
            $this->redirect($this->route("404"));
        }
        $em_post = new PostGateway($this->con);
        $em_comment = new ReviewGateway($this->con);
        $post = $em_post->find($id);
        if($post != NULL){
            $reviews = $em_comment->findByPost($post);
            $this->render('PostAdmin', [
                'post' => $post,
                'reviews' => $reviews
            ]);
        }else{
            $this->redirect($this->route("404"));
        }

    }

    public function deleteComment(int $idPost, int $idComment){
        try{
            Validation::int($idComment);
            Validation::int($idPost);
            $em_comment = new ReviewGateway($this->con);
            $comment = $em_comment->find($idComment);
            $em_comment->remove($comment);
            $this->redirect($this->route("AdminBlog",[$idPost]));
        } catch (Exception $e) {
            $this->redirect($this->route("404"));
        }
    }

    public function updatePost(int $idPost):void
    {
        try{
            Validation::int($idPost);
        }catch (DatabaseException $e){
            $this->redirect($this->route("404"));
            return;
        }

        try{
            $title = $_POST['title'] ?? "";
            try {
                Validation::require($title);
                Validation::maxChar($title, 255);
            } catch (DatabaseException $e) {
                throw new Exception("Invalid title - max 255 characters");
            }
            $description = $_POST['description'] ?? "";
            try {
                Validation::require($description);
                Validation::maxChar($description, 2000);
            } catch (DatabaseException $e) {
                throw new Exception("Invalid description - max 2000 characters");
            }

            try{
                $em_post = new PostGateway($this->con);
                $post = $em_post->find($idPost);
                $post->setTitle($title);
                $post->setDescription($description);
                $em_post->update($post);
            }catch (Exception $e){
                throw new Exception("Please contact an administrator - ".$e->getMessage());
            }
        }catch (Exception $e) {
            $this->redirect($this->route("AdminBlog",[$idPost]), errors: $e->getMessage());
            return;
        }
        $this->redirect($this->route("AdminBlog",[$idPost]));
    }
}