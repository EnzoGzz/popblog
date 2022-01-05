<?php

namespace App\Controller;

use App\Model\Post;
use Exception;
use Utils\Database\Gateway\ContactGateway;
use Utils\Database\Gateway\PostGateway;
use Utils\Database\Gateway\ReviewGateway;
use Utils\Exception\ValidationException;
use Utils\ModelAdmin;
use Utils\Validation;

class AdminController extends Controller
{

    /**
     * @return void
     * load and render all post - admin
     */
    public function post()
    {
        $em_post = new PostGateway($this->con);
        $posts = $em_post->findAll();
        $this->render('BlogAdmin',[
            "posts" => $posts
        ]);
    }

    /**
     * @return void
     * render page for create post
     */
    public function createPost(){
        $this->render('PostCreate');
    }

    /**
     * @return void
     * insert post in database
     */
    public function insertPost()
    {
        try{
            $title = $_POST['title'] ?? "";
            try {
                Validation::require($title);
                Validation::maxChar($title, 255);
            } catch (ValidationException) {
                throw new Exception("Invalid title - max 255 characters");
            }
            $desc = $_POST['description'] ?? "";
            try {
                Validation::require($desc);
                Validation::maxChar($desc, 2000);
            } catch (ValidationException) {
                throw new Exception("Invalid description - max 2000 characters");
            }

            try {
                $em_post = new PostGateway($this->con);
                $post = new Post();
                $post->setTitle($title);
                $post->setDescription($desc);
                $em_post->insert($post);
            } catch (Exception) {
                throw new Exception("Please contact an administrator");
            }
        }catch (Exception $e){
            $this->redirect($this->route("CreatePost"),errors: $e->getMessage());
            return;
        }
        $this->redirect($this->route("AdminBlogs"));
    }

    /**
     * @return void
     * load and render all contact - admin
     */
    public function showContact()
    {
        $em_post = new ContactGateway($this->con);
        $contacts = $em_post->findAll();
        $this->render('ContactAdmin',[
            "contacts" => $contacts
        ]);
    }

    /**
     * @param $id
     * @return void
     * @throws ValidationException
     * delete contact
     */
    public function deleteContact($id)
    {
        Validation::int($id);
        $em_contact = new ContactGateway($this->con);
        $contact = $em_contact->find($id);
        $em_contact->remove($contact);
        $this->redirect($this->route("AdminContact"));
    }

    /**
     * @return void
     * logout administrator
     */
    public function logout(){
        ModelAdmin::logout();
        $this->redirect($this->route("Home"));
    }

    /**
     * @param int $id
     * @return void
     * @throws ValidationException
     * delete post
     */
    public function deletePost(int $id)
    {
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
    }

    /**
     * @param int $id
     * @return void
     * @throws ValidationException
     * load and render post
     */
    public function showPost(int $id)
    {
        Validation::int($id);
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
            throw new Exception();
        }

    }

    /**
     * @param int $idPost
     * @param int $idComment
     * @return void
     * @throws ValidationException
     * delete comment
     */
    public function deleteComment(int $idPost, int $idComment){
        Validation::int($idComment);
        Validation::int($idPost);
        $em_comment = new ReviewGateway($this->con);
        $comment = $em_comment->find($idComment);
        $em_comment->remove($comment);
        $this->redirect($this->route("AdminBlog",[$idPost]));
    }

    /**
     * @param int $idPost
     * @return void
     * @throws ValidationException
     * update comment
     */
    public function updatePost(int $idPost):void
    {
        Validation::int($idPost);
        try{
            $title = $_POST['title'] ?? "";
            try {
                Validation::require($title);
                Validation::maxChar($title, 255);
            } catch (ValidationException) {
                throw new Exception("Invalid title - max 255 characters");
            }
            $description = $_POST['description'] ?? "";
            try {
                Validation::require($description);
                Validation::maxChar($description, 2000);
            } catch (ValidationException) {
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