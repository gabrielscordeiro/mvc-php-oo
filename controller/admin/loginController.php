<?php

namespace controller\admin;
use lib\Controller;
use lib\Input;
use lib\TypeForm;
use lib\Token;
use lib\Validar;
use lib\Usuario;
use lib\Redirecionar;
use lib\Cookie;
use lib\Config;
use lib\Session;

class loginController extends Controller{
    public function index(){


        $campo = new Input();
        $campo->addParams(array('required' => true, 'class' => 'campo bootstrap', 'ng-model' => 'funcao()'));
        $campo->campo(TypeForm::TEXT, "nome", "Nome");
        $campo->printHtml();

        if(Input::exists()){
            if(Token::check(Input::get('token'))){
                $validar = new Validar();
                $validacao = $validar->check($_POST, array(
                    'usuario' => array(
                        'required' => true
                    ),
                    'senha' => array(
                        'required' => true
                    )
                ));

                if($validacao->aprovada()){
                    $usuario = new Usuario();
                    $login = $usuario->login(Input::get('usuario'), Input::get('senha'));

                    if($login){
                        Redirecionar::para('home');
                    }
                    else {
                        echo 'Desculpe, falhou';
                    }
                }
                else {

                    foreach($validacao->erros() as $erro){
                        echo $erro.'<br>';
                    }
                }
            }
        }

        $this->view();
    }
}
