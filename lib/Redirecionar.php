<?php
namespace lib;

class Redirecionar {
    public static function para($local = null){
        if($local){
            if(is_numeric($local)){
                switch($local){
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include('./includes/erros/404.php');
                        exit();
                    break;
                }
            }
            //melhorar os bugs dessa classe
            header('Location: '.$local);
            exit();
        }
    }
}

?>
