<?php
namespace lib;

use lib\Database;

class Validar {
    private $_aprovada = false;
    private $_erros = array();
    private $_db = null;

    public function __construct(){
        $this->_db = Database::getInstance();
    }

    public function check($fonte, $itens = array()){
        foreach($itens as $item => $regras){
            foreach($regras as $regra => $valorRegra){

                $valorInput = trim($fonte[$item]);
                $item = escape($item);

                if($regra === 'required' && empty($valorInput)){
                    $this->adicionarErro("{$item} é obrigatório");
                }
                else if(!empty($valorInput)){
                    switch($regra){
                        case 'min':
                            if(strlen($valorInput) < $valorRegra){
                                $this->adicionarErro("{$item} deve ter um valor mínimo de {$valorRegra} caracteres");
                            }
                        break;
                        case 'max':
                            if(strlen($valorInput) > $valorRegra){
                                $this->adicionarErro("{$item} deve ter um valor máximo de {$valorRegra} caracteres");
                            }
                        break;
                        case 'matches':
                            if($valorInput != $fonte[$valorRegra]){
                                $this->adicionarErro("{$valorRegra} deve ter o mesmo valor que o campo {$item}");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($valorRegra, array($item, '=', $valorInput));
                            if($check->count()){
                                $this->adicionarErro("{$item} já existe um usuário {$valorInput} registrado!");
                            }
                        break;
                    }
                }

            }
        }

        if(empty($this->_erros)){
            $this->_aprovada = true;
        }

        return $this;
    }

    private function adicionarErro($erro){
        $this->_erros[] = $erro;
    }

    public function erros(){
        return $this->_erros;
    }

    public function aprovada(){
        return $this->_aprovada;
    }
}
?>
