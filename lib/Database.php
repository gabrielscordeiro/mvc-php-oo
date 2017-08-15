<?php

namespace lib;

use \PDO;

class Database{
   private static $_instance = null;
   private $_pdo,
           $_query,
           $_error = false,
           $_results,
           $_count = 0;
   private function __construct(){
      try{
         $this->_pdo = new PDO('pgsql:host='.Config::get('pgsql/host').';dbname='.Config::get('pgsql/database'), Config::get('pgsql/usuario'), Config::get('pgsql/senha'));
      }
      catch(PDOException $e){
         die($e->getMessage());
      }
   }

   public static function getInstance(){
      if(!isset(self::$_instance)){
         self::$_instance = new Database();
      }
      return self::$_instance;
   }

   public function query($sql, $params = array()){

      $this->_error = false;
      $this->_query = $this->_pdo->prepare($sql);
      if($this->_query){ //se conseguiu preparar o sql
         $x = 1;
         if(count($params)){
            foreach($params as $param){
               $this->_query->bindValue($x, $param); //função padrão que troca os ? da query pelos valores definidos no array
               $x++;
            }
         }

         if($this->_query->execute()){
            $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
            $this->_count = $this->_query->rowCount();
         }
         else {
            $this->_error = true;
         }
      }

      return $this;
   }

   public function acao($acao, $tabela, $where = array()){
      if(count($where) === 3){
         $operadores = array('=', '>', '<', '>=', '<=');
         $campo    = $where[0];
         $operador = $where[1];
         $valor    = $where[2];

         if(in_array($operador, $operadores)){
            $sql = "{$acao} FROM {$tabela} WHERE {$campo} {$operador} ?";

            if(!$this->query($sql, array($valor))->error()){
               return $this;
            }
         }
      }
      return false;
   }

   /*Ainda quero implementar pra conseguir usar o get sem parametro, como se fosse retornar todos os itens de uma tabela*/
   public function get($tabela, $where = array()){
      return $this->acao('SELECT *', $tabela, $where);
   }

   public function delete($tabela, $where){
      return $this->acao('DELETE', $tabela, $where);
   }

   public function insert($tabela, $colunas = array()){

      $keys = array_keys($colunas);
      $valores = '';
      $x = 1;

      foreach($colunas as $coluna){
         $valores .= '?';
         if($x < count($colunas)){
            $valores .= ', ';
         }
         $x++;
      }

      $sql = "INSERT INTO {$tabela} (".implode(',', $keys).") VALUES ({$valores})";

      if(!$this->query($sql, $colunas)->error()){
         return true;
      }

      return false;
   }

   /*pode ser implementada para aceitar mais clausulas no where, por enquanto só está no codigo*/
   public function update($tabela, $id, $colunas){
      $set = '';
      $x = 1;

      foreach($colunas as $nome => $valor){
         $set .= "{$nome} = ?";
         if($x < count($colunas)){
            $set .= ', ';
         }
         $x++;
      }

      $sql = "UPDATE {$tabela} SET {$set} WHERE codigo = {$id}";

      if(!$this->query($sql, $colunas)->error()){
         return true;
      }

      return false;
   }

   public function results(){
      return $this->_results;
   }

   public function first(){
      return $this->results()[0];
   }

   public function error(){
      return $this->_error;
   }

   public function count(){
      return $this->_count;
   }
}
