<?php

define('APP_ROOT', 'mvc-php-oo');
require_once 'helper/Bootstrap.php';

use lib\System;

//Conseguiriamos fazer isso aqui ser uma classe abstrata pra chamar apenas com System::Run() ?
$System = new System;
$System->Run();

//echo Config::get('pgsql/host'); //quando é classe abstrata, nem precisa declarar

/*$user = Database::getInstance()->query('SELECT usuario FROM usuario WHERE usuario = ?', array('Gabriel'));
$user = Database::getInstance()->get('usuario', array('usuario', '=', 'Gabriel'));

if(!$user->count()){
   echo 'no user';
}
else {
   echo $user->first()->nome;
}
*/
/*
$user = Database::getInstance()->insert('usuario', array(
   "senha" => "novasenha",
   "nome" => "Guria Cachorra",
   "salt" => "salt"
));

//$user retorna true ou false no insert/update, util pra fazer algumas validações

$user = Database::getInstance()->update('usuario', 3, array(
   "senha" => "novasenha",
   "nome" => "Guria Cachorra"
));
*/
