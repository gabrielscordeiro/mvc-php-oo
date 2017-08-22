<?php
function escape($string){
   return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function char_at($str, $pos){
   return $str[$pos];
}
