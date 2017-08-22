<?php
namespace lib;
use lib\System;

class Redirecionar{

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

            header('Location: '.self::tratamentoBarraUrl($local));
            exit();
        }
    }

    public function tratamentoBarraUrl($local){
        $s = new System();
        $barra = char_at($s->getUrl(), strlen($s->getUrl())-1);
        if($barra != '/'){
            $local = $s->getArea().'/'.$local;
        }
        return $local;
    }
}

?>
