<?php

class Validation
{
    /**
     * @throws Exception
     */
    public static function int($int){
        if(!filter_var($int, FILTER_VALIDATE_INT)){
            throw new Exception("Int invalide");
        }
    }

    /**
     * @throws Exception
     */
    public static function require($var){
        if(empty($var)){
            throw new Exception("Variable vide");
        }
    }
}