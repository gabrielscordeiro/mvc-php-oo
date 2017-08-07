<?php
require_once('core/init.php');

//echo Config::get('pgsql/host');

/*$user = Database::getInstance()->query('SELECT usuario FROM usuario WHERE usuario = ?', array('Gabriel'));
$user = Database::getInstance()->get('usuario', array('usuario', '=', 'Gabriel'));

if(!$user->count()){
   echo 'no user';
}
else {
   echo $user->first()->nome;
}
*/

$user = Database::getInstance()->insert('usuario', array(
   "senha" => "novasenha",
   "nome" => "Guria Cachorra",
   "salt" => "salt"
));

//$user retorna true ou false no insert

$user = Database::getInstance()->update('usuario', 3, array(
   "senha" => "novasenha",
   "nome" => "Guria Cachorra"
));
