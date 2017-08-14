<?php
namespace lib;
class Session {
    public static function exists($nome){
        return (isset($_SESSION[$nome])) ? true : false;
    }

    public static function put($nome, $valor){
        return $_SESSION[$nome] = $valor;
    }

    public static function get($nome){
        return $_SESSION[$nome];
    }

    public static function delete($nome){
        if(self::exists($nome)){
            unset($_SESSION[$nome]);
        }
    }

    public static function flash($nome, $string = ''){
        if(self::exists($nome)){
            $session = self::get($nome);
            self::delete($nome);
            return $session;
        }
        else{
            self::put($nome, $string);
        }
    }
}
?>
