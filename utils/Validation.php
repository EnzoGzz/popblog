<?php
namespace Utils;

use Utils\Exception\ValidationException;

class Validation
{
    /**
     * @param $var
     * @throws ValidationException
     */
    public static function int($var){
        if(!filter_var($var, FILTER_VALIDATE_INT))throw new ValidationException("Entier invalide");
    }

    /**
     * @param $var
     * @throws ValidationException
     */
    public static function require($var){
        if(empty($var)){
            throw new ValidationException("Variable vide");
        }
    }

    /**
     * @param $var
     * @return mixed
     */
    public static function string($var){
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    /**
     * @param $var
     * @param $min
     * @param $max
     * @throws ValidationException
     */
    public static function between($var,$min, $max)
    {
        try{
            self::min($var,$min);
            self::max($var,$max);
        }catch (ValidationException $e){
            throw new ValidationException("Le nombre doit être compris entre $min et $max");
        }
    }

    /**
     * @param $var
     * @param $max
     * @throws ValidationException
     */
    public static function max($var,$max){
        if($var > $max) throw new ValidationException("$var est supérieur à $max");
    }

    /**
     * @param $var
     * @param $min
     * @throws ValidationException
     */
    public static function min($var,$min){
        if($var < $min) throw new ValidationException("$var est inférieur à $min");
    }

    /**
     * @param string $var
     * @param int $max
     * @throws ValidationException
     */
    public static function maxChar(string $var, int $max)
    {
        $var = self::string($var);
        if(strlen($var) > $max)throw new ValidationException("Le nombre de caractère ne doit pas exceder $max");
    }

    /**
     * @param string $var
     * @param int $min
     * @throws ValidationException
     */
    public static function minChar(string $var, int $min)
    {
        $var = self::string($var);
        if(strlen($var) < $min)throw new ValidationException("Le nombre de caractère doit être supérieur à $min");
    }
}