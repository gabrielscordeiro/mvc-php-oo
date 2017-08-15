<?php

namespace controller\admin;
use lib\Controller;
use lib\Input;
use lib\Token;
use lib\Validar;
use lib\Usuario;
use lib\Redirecionar;

class loginController extends Controller{
    public function index(){
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
                    $remember = (Input::get('remember') == 'on') ? true : false;
                    $login = $usuario->login(Input::get('usuario'), Input::get('senha'), $remember);

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
