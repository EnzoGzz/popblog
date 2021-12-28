<?php

namespace App\Controller;

use App\Model\Contact;
use App\Model\Review;
use App\Model\Post;
use App\Model\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Utils\Database\Gateway\ContactGateway;
use Utils\Database\Gateway\PostGateway;
use Utils\Database\Gateway\ReviewGateway;
use Utils\Database\Gateway\UserGateway;
use Utils\ModelAdmin;
use Utils\Validation;
use Utils\Exception\DatabaseException;

class UserController extends Controller
{


    public function home()
    {
        $this->render('Home');
    }

    public function post()
    {
        $em_post = new PostGateway($this->con);
        $posts = $em_post->findAll();
        $this->render('Blog',[
            "posts" => $posts
        ]);
    }

    public function showPost(int $id)
    {
        try{
            Validation::int($id);
        } catch (DatabaseException $e) {
            $this->redirect($this->route("404"));
        }
        $em_post = new PostGateway($this->con);
        $em_review = new ReviewGateway($this->con);
        $post = $em_post->find($id);
        if($post != NULL){
            $reviews = $em_review->findByPost($post);
            $this->render('Post', [
                'post' => $post,
                'reviews' => $reviews
            ]);
        }else{
            $this->redirect($this->route("404"));
        }

    }

    /**
     * @param int $id
     */
    public function insertComment(int $id){

        try{
            Validation::int($id);
        } catch (DatabaseException $e) {
            $this->redirect($this->route("Blogs"));
            return;
        }
        try{
            $username = $_POST['username'];
            try{
                Validation::require($username);
                Validation::maxChar($username,255);
            } catch (DatabaseException $e) {
                $this->errors["InvalidUsername"] = "Invalid username - max 255 characters";
                throw $e;
            }

            $commentText = $_POST['comment'];
            try{
                Validation::require($commentText);
                Validation::maxChar($commentText,2000);
            } catch (DatabaseException $e) {
                $this->errors["InvalidComment"] = "Invalid comment - max 255 characters";
                throw $e;
            }

            try{
                $em_post = new PostGateway($this->con);
                $em_review = new ReviewGateway($this->con);

                $comment = new Review();
                $comment->setUsername($username);
                $comment->setComment($commentText);
                $comment->setPost($em_post->find($id)->getId());
                $em_review->insert($comment);
            }catch (Exception $e) {
                $this->errors["Error"] = "Please contact an administrator";
            }
        }catch (Exception $e){
        } finally {
            $this->redirect($this->route("Blog",[$id]));
        }
    }

    public function contact(){
        $this->render('Contact');
    }

    public function contactSend(){

        try{
            $email = $_POST["email"];
            try{
                Validation::require($email);
            }catch (DatabaseException $e){
                throw new Exception("Invalid email");
            }

            $subject = $_POST["subject"];
            try{
                Validation::require($subject);
            }catch (DatabaseException $e){
                throw new Exception("Invalid subject");
            }

            $message = $_POST["message"];
            try{
                Validation::require($message);
            }catch (DatabaseException $e){
                throw new Exception("Invalid message");
            }

            try{
                $em_contact = new ContactGateway($this->con);
                $contact = new Contact();
                $contact->setEmail($email);
                $contact->setSubject($subject);
                $contact->setMessage($message);
                $em_contact->insert($contact);
            }catch (DatabaseException $e) {
                throw new Exception("Please contact an administrator");
            }
        }catch (Exception $e){
            $this->redirect($this->route("Contact"),errors:$e->getMessage());
        }
        $this->redirect($this->route("Contact"));

    }

    public function loginPost()
    {
        try {
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? "";

            Validation::require($username);
            Validation::maxChar($username, 255);
            Validation::require($password);
            Validation::maxChar($password, 255);
            ModelAdmin::login($username,$password);
            $this->redirect($this->route("Home"));

        }catch (Exception $e){
            $this->redirect($this->route("Login"), errors:"Invalid login");
        }

    }

    public function login(){
        $this->render("Login");
    }
}