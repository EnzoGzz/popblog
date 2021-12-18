<?php

namespace App\Controller;

use App\Model\Comment;
use App\Model\Post;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use utils\Validation;
use utils\Exception\ValidationException;

class UserController extends Controller
{


    public function home()
    {
        $this->render('Home');
    }

    public function blog()
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
            //Vue erreur
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
            //Vue erreur
        }

    }

    /**
     * @param int $id
     */
    public function insertComment(int $id){
        try{
            Validation::int($id);
        } catch (ValidationException $e) {
            //Vue erreur
        }

        $username = $_POST['username'];
        try{
            Validation::require($username);
            Validation::maxChar($username,255);
        } catch (ValidationException $e) {
            //Vue erreur
        }
        $commentText = $_POST['commentaire'];
        try{
            Validation::require($commentText);
            Validation::maxChar($commentText,2000);
        } catch (ValidationException $e) {
            //Vue erreur
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
            //Vue erreur
        }

        $this->redirect("/post/$id");
    }

    public function contact(){
        $this->render('Contact');
    }
}