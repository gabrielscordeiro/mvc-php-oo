<?php
namespace lib;

class Input extends TypeForm{

    public $campos;
    private $html;
    private $params;

    public function campo($tipo, $nome, $label = 'Novo campo'){

        $this->startForm();
        $this->addParams(array('name'=>$nome, 'id'=>$nome));

        if(isset($nome) && !is_numeric($nome) && !empty($nome)){
            $this->html .= '<label for="'.$nome.'">'.$label.'</label>';
            $this->html .= '<input '.$this->getParams().'>';
        }

        $this->endForm();
    }

    public function addParams($itens){
        if(!empty($itens)){
            foreach($itens as $atributo => $valor){
                $this->params .= $atributo.'="'.$valor.'"';
            }
        }
    }

    private function getParams(){
        return $this->params;
    }


    private function startForm($method = 'post'){
        $this->html = '<form method="'.$method.'" enctype="multipart/form-data">';
    }

    private function endForm(){
        $this->html .= '</form>';
    }

    public function printHtml(){
        echo $this->html;
    }

    public static function exists($type = 'post'){
        switch($type){
            case 'post':
                return (!empty($_POST)) ? true : false;
            case 'get':
                return (!empty($_GET)) ? true : false;
            default:
                return false;
        }
    }

    public static function get($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        }
        else if(isset($_GET[$item])){
            return $_GET[$item];
        }

        return '';
    }


}
