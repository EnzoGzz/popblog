<?php

class Validation
{
    /**
     * @throws Exception
     */
    public static function int($var){
        if(!filter_var($var, FILTER_VALIDATE_INT)){
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

    public static function string($var){
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    /**
     * @throws Exception
     */
    public static function between($var, $between1 = null, $between2 = null):bool
    {
        self::int($var);
        if($between1 == null)$between1 = $var-1;
        if($between2 == null)$between2 = $var+1;
        self::int($between1);
        self::int($between2);
        if($between1 < $var && $var < $between2){
            return true;
        }
        return false;
    }
}