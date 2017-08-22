<?php
session_start();

$GLOBALS['config'] = array(
   'pgsql' => array(
      'host' => '127.0.0.1',
      'usuario' => 'postgres',
      'senha' => 'root',
      'database' => 'postgres'
   ),
   'remember' => array(
      'cookie_name' => 'hash',
      'cookie_expiry' => 604800
   ),
   'session' => array(
      'session_name' => 'usuario',
      'token_name' => 'token'
   )
);

spl_autoload_register(function($class) {
    $file = str_replace('\\', '/', $class).".php";

    if (file_exists($file)) {
        require_once $file;
    }
});

require_once('funcoes/sanitize.php');
