<?php

namespace App\Controller;

use App\Model\Contact;
use App\Model\Review;
use App\Model\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Utils\Validation;
use Utils\Exception\ValidationException;

class AdminController extends Controller
{


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
        try{
            $title = $_POST['title'] ?? "";
            try {
                Validation::require($title);
                Validation::maxChar($title, 255);
            } catch (ValidationException $e) {
                $this->errors["InvalidTitle"] = "Invalid title - max 255 characters";
                throw $e;
            }
            $desc = $_POST['description'] ?? "";
            try {
                Validation::require($desc);
                Validation::maxChar($desc, 2000);
            } catch (ValidationException $e) {
                $this->errors["InvalidDescription"] = "Invalid description - max 2000 characters";
                throw $e;
            }

            try {
                $post = new Post();
                $post->setTitle($title);
                $post->setDescription($desc);
                $this->em->persist($post);
                $this->em->flush();
            } catch (Exception $e) {
                $this->errors["Error"] = "Please contact an administrator";
            }
        }catch (Exception $e){

        }
        finally {
            $this->redirect($this->route("Blogs"));
        }
    }

    public function showContact()
    {
        $em_post = $this->em->getRepository(Contact::class);
        $contacts = $em_post->findAll();
        $this->render('ContactAdmin',[
            "contacts" => $contacts
        ]);
    }

    public function logout(){
        session_destroy();
        $this->redirect($this->route("Home"));
    }

    public function deletePost($id)
    {
        try{
            Validation::int($id);
            $em_post = $this->em->getRepository(Post::class);
            $em_comment = $this->em->getRepository(Review::class);
            $post = $em_post->find($id);
            $comments = $em_comment->findBy(["post"=>$post]);
            foreach ($comments as $comment) {
                $this->em->remove($comment);
            }
            $this->em->remove($post);
            $this->em->flush();
            $this->redirect($this->route("AdminBlogs"));
        }catch (Exception $e) {
            $this->redirect($this->route("error404"));
        }
    }

    public function showPost(int $id)
    {
        try{
            Validation::int($id);
        } catch (ValidationException $e) {
            $this->redirect($this->route("404"));
        }
        $em_post = $this->em->getRepository(Post::class);
        $em_comment = $this->em->getRepository(Review::class);
        $post = $em_post->find($id);
        if($post != NULL){
            $reviews = $em_comment->findBy(["post"=>$post->getId()]);
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
            $em_comment = $this->em->getRepository(Review::class);
            $em_post = $this->em->getRepository(Post::class);
            $post = $em_post->find($idPost);
            $comment = $em_comment->find($idComment);
            $this->em->remove($comment);
            $this->em->flush();
            $this->redirect($this->route("AdminBlog",[$idPost]));
        } catch (Exception $e) {
            $this->redirect($this->route("404"));
        }
    }

    public function updatePost(int $idPost){
        try{
            Validation::int($idPost);
            $em_post = $this->em->getRepository(Post::class);
            $post = $em_post->find($idPost);
            $this->render("UpdatePostAdmin",[
                "post" => $post
            ]);
        } catch (Exception $e) {
            $this->redirect($this->route("404"));
        }
    }

    public function updatePostPost(int $idPost):void
    {
        try{
            Validation::int($idPost);
        }catch (ValidationException $e){
            $this->redirect($this->route("404"));
            return;
        }

        try{
            $title = $_POST['title'] ?? "";
            try {
                Validation::require($title);
                Validation::maxChar($title, 255);
            } catch (ValidationException $e) {
                $this->errors["InvalidTitle"] = "Invalid title - max 255 characters";
                throw $e;
            }
            $description = $_POST['description'] ?? "";
            try {
                Validation::require($description);
                Validation::maxChar($description, 2000);
            } catch (ValidationException $e) {
                $this->errors["InvalidDescription"] = "Invalid description - max 2000 characters";
                throw $e;
            }

            try{
                $em_post = $this->em->getRepository(Post::class);
                $post = $em_post->find($idPost);
                $post->setTitle($title);
                $post->setDescription($description);
                $this->em->flush();
            }catch (Exception $e){
                $this->errors["Error"] = "Please contact an administrator";
            }
        }catch (Exception $e){
        } finally {
            $this->redirect($this->route("AdminBlogs"));
            return;
        }
    }
}