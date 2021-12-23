<?php

namespace App\Controller;

use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Utils\Validation;
use Utils\Exception\ValidationException;

class UserController extends Controller
{


    public function home()
    {
        $this->render('Home');
    }

    public function post()
    {
        $em_post = $this->em->getRepository(Post::class);
        $posts = $em_post->findAll();
        $this->render('Blog',[
            "posts" => $posts
        ]);
    }

    public function showPost(int $id)
    {
        try{
            Validation::int($id);
        } catch (ValidationException $e) {
            $this->redirect($this->route("404"));
        }
        $em_post = $this->em->getRepository(Post::class);
        $em_comment = $this->em->getRepository(Comment::class);
        $post = $em_post->find($id);
        if($post != NULL){
            $comments = $em_comment->findBy(["post"=>$post->getId()]);
            $this->render('Post', [
                'post' => $post,
                'comments' => $comments
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
        } catch (ValidationException $e) {
            $this->errors["InvalidBlog"] = "Invalid Blog";
        }

        $username = $_POST['username'];
        try{
            Validation::require($username);
            Validation::maxChar($username,255);
        } catch (ValidationException $e) {
            $this->errors["InvalidUsername"] = "Invalid username - max 255 characters";
        }
        $commentText = $_POST['commentaire'];
        try{
            Validation::require($commentText);
            Validation::maxChar($commentText,2000);
        } catch (ValidationException $e) {
            $this->errors["InvalidComment"] = "Invalid comment - max 255 characters";
        }
        $em_post = $this->em->getRepository(Post::class);

        $comment = new Comment();
        $comment->setUsername($username);
        $comment->setComment($commentText);
        $comment->setPost($em_post->find($id));
        try{
            $this->em->persist($comment);
            $this->em->flush();
        }catch (OptimisticLockException | ORMException $e) {
            $this->errors["Error"] = "Please contact an administrator";
        }

        $this->redirect("/post/$id");
    }

    public function contact(){
        $this->render('Contact');
    }

    public function loginPost()
    {
        try{
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? "";

            Validation::require($username);
            Validation::maxChar($username,255);
            Validation::require($password);
            Validation::maxChar($password,255);


            $em_user = $this->em->getRepository(User::class);
            $user = $em_user->findOneBy(["username"=>$username]);
            if($user != NULL){
                if(password_verify($password,$user->getPassword())){
                    $_SESSION["login"]="login";
                }else{
                    throw new Exception("Invalid password");
                }
            }else{
                throw new Exception("Invalid username");
            }
        }catch (Exception $e){
            $this->errors["InvalidLogin"] = "Invalid login";
        } finally {
            $this->redirect($this->route("Home"));
        }

    }

    public function login(){
        $this->render("Login");
    }
}