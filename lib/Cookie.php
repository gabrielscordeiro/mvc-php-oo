<?php
namespace lib;

class Cookie{
    public static function exists($nome){
        return (isset($_COOKIE[$nome])) ? true : false;
    }

    public static function get($nome){
        return $_COOKIE[$nome];
    }

    public static function put($nome, $valor, $expiracao){
        if(setcookie($nome, $valor, time() + $expiracao, '/')){
            return true;
        }
        return false;
    }

    public static function delete($nome){
        self::put($nome, '', time() - 1);
    }
}
?>
