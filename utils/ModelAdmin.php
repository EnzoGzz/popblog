<?php

namespace Utils;

use Exception;
use Utils\Database\Gateway\UserGateway;
use Utils\Exception\ValidationException;

class ModelAdmin
{
    /**
     * @throws Exception
     */
    public static function login($username, $password)
    {
        global $con;

        $em_user = new UserGateway($con);
        $user = $em_user->findOneByUsername($username);
        if($user != NULL){
            if(password_verify($password,$user->getPassword())){
                $_SESSION["login"]=password_hash($user->getUsername(),PASSWORD_DEFAULT);
            }else{
                throw new Exception("Invalid password");
            }
        }else{
            throw new Exception("Invalid username");
        }
    }

    public static function isLogin():bool
    {
        if (isset($_SESSION["login"])) {
            return true;
        }
        return false;
    }

    public static function logout()
    {
        session_destroy();
    }
}