<?php

namespace App\Controller;

use App\Model\Contact;
use App\Model\Review;
use Exception;
use Utils\Database\Gateway\ContactGateway;
use Utils\Database\Gateway\PostGateway;
use Utils\Database\Gateway\ReviewGateway;
use Utils\Exception\ValidationException;
use Utils\ModelAdmin;
use Utils\Validation;
use Utils\Exception\DatabaseException;

class UserController extends Controller
{

    /**
     * @return void
     * render home page
     */
    public function home()
    {
        $this->render('Home');
    }

    /**
     * @return void
     * load and render all post
     */
    public function post()
    {
        $em_post = new PostGateway($this->con);
        $posts = $em_post->findAll();
        $this->render('Blog',[
            "posts" => $posts
        ]);
    }

    /**
     * @param int $id
     * @return void
     * @throws ValidationException
     * @throws Exception
     * load and render post
     */
    public function showPost(int $id)
    {
        Validation::int($id);
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
            throw new Exception("No post");
        }

    }

    /**
     * @param int $id
     * @return void
     * insert comment
     */
    public function insertComment(int $id){

        try{
            Validation::int($id);
        } catch (ValidationException) {
            $this->redirect($this->route("Blogs"));
            return;
        }
        try{
            $username = $_POST['username'];
            try{
                Validation::require($username);
                Validation::maxChar($username,255);
            } catch (ValidationException) {
                throw new Exception("Invalid username");
            }

            $commentText = $_POST['comment'];
            try{
                Validation::require($commentText);
                Validation::maxChar($commentText,2000);
            } catch (ValidationException) {
                throw new Exception("Invalid comment");
            }

            try{
                $em_post = new PostGateway($this->con);
                $em_review = new ReviewGateway($this->con);

                $comment = new Review();
                $comment->setUsername($username);
                $comment->setComment($commentText);
                $comment->setPost($em_post->find($id)->getId());
                $em_review->insert($comment);
            }catch (Exception) {
                throw new Exception("Please contact an administrator");
            }
        }catch (Exception $e){
            $this->redirect($this->route("Blog",[$id]),errors:$e->getMessage());
            return;
        }
        $this->redirect($this->route("Blog",[$id]));
    }

    /**
     * @return void
     * render contact page
     */
    public function contact(){
        $this->render('Contact');
    }

    /**
     * @return void
     * insert contact in database
     */
    public function contactSend(){

        try{
            $email = $_POST["email"];
            try{
                Validation::require($email);
            }catch (ValidationException){
                throw new Exception("Invalid email");
            }

            $subject = $_POST["subject"];
            try{
                Validation::require($subject);
            }catch (ValidationException){
                throw new Exception("Invalid subject");
            }

            $message = $_POST["message"];
            try{
                Validation::require($message);
            }catch (ValidationException){
                throw new Exception("Invalid message");
            }

            try{
                $em_contact = new ContactGateway($this->con);
                $contact = new Contact();
                $contact->setEmail($email);
                $contact->setSubject($subject);
                $contact->setMessage($message);
                $em_contact->insert($contact);
            }catch (DatabaseException) {
                throw new Exception("Please contact an administrator");
            }
        }catch (Exception $e){
            $this->redirect($this->route("Contact"),errors:$e->getMessage());
        }
        $this->redirect($this->route("Contact"));

    }

    /**
     * @return void
     * test login
     */
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

        }catch (Exception){
            $this->redirect($this->route("Login"), errors:"Invalid login");
        }

    }

    public function easteregg(){
        $this->render('Easteregg');
    }

    /**
     * @return void
     * render login page
     */
    public function login(){
        $this->render("Login");
    }
}