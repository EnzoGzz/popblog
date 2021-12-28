<?php
namespace Utils;

use Utils\Exception\DatabaseException;

class Validation
{
    /**
     * @param $var
     * @throws DatabaseException
     */
    public static function int($var){
        if(!filter_var($var, FILTER_VALIDATE_INT))throw new DatabaseException("Entier invalide");
    }

    /**
     * @param $var
     * @throws DatabaseException
     */
    public static function require($var){
        if(empty($var)){
            throw new DatabaseException("Variable vide");
        }
    }

    /**
     * @param $var
     * @return mixed
     */
    public static function string($var): mixed
    {
        return filter_var($var, FILTER_SANITIZE_STRING);
    }

    /**
     * @param $var
     * @param $min
     * @param $max
     * @throws DatabaseException
     */
    public static function between($var,$min, $max)
    {
        try{
            self::min($var,$min);
            self::max($var,$max);
        }catch (DatabaseException $e){
            throw new DatabaseException("Le nombre doit être compris entre $min et $max");
        }
    }

    /**
     * @param $var
     * @param $max
     * @throws DatabaseException
     */
    public static function max($var,$max){
        if($var > $max)throw new DatabaseException("$var est supérieur à $max");
    }

    /**
     * @param $var
     * @param $min
     * @throws DatabaseException
     */
    public static function min($var,$min){
        if($var < $min)throw new DatabaseException("$var est inférieur à $min");
    }

    /**
     * @param string $var
     * @param int $max
     * @throws DatabaseException
     */
    public static function maxChar(string $var, int $max)
    {
        $var = self::string($var);
        if(strlen($var) > $max)throw new DatabaseException("Le nombre de caractère ne doit pas exceder $max");
    }

    /**
     * @param string $var
     * @param int $min
     * @throws DatabaseException
     */
    public static function minChar(string $var, int $min)
    {
        $var = self::string($var);
        if(strlen($var) < $min)throw new DatabaseException("Le nombre de caractère doit être supérieur à $min");
    }
}