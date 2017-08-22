<?php
namespace lib;

class Input extends TypeForm{

    public $campos;
    public $html;

    public function campo($tipo, $nome, $label = 'Novo campo'){

        $this->startForm();

        if(isset($nome) && !is_numeric($nome) && !empty($nome)){
            $this->html += '<label for="'.$nome.'">'.$label.'</label>';
            $this->html += '<input name="'.$nome.'" id="'.$nome.'">'; //precisa de um loop pra adicionar os demais parametros
        }

        $this->endForm();
    }

    private function startForm($method = 'post'){
        $this->html = '<form method="'.$method.'" enctype="multipart/form-data">';
    }

    private function endForm(){
        $this->html += '</form>';
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
