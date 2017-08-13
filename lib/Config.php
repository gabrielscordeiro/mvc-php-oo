<?php
namespace lib;

class Config {

    public static function get($caminho = null){
      if($caminho){
         $config = $GLOBALS['config'];
         $caminho = explode('/', $caminho);

         foreach ($caminho as $pedaco) {
            if(isset($config[$pedaco])){
               $config = $config[$pedaco];
            }
         }

         return $config;
      }

      return false;
   }
}
