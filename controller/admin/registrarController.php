<?php

namespace controller\admin;

use lib\Controller;
use lib\Input;
use lib\Validar;
use lib\Token;
use lib\Session;

class registrarController extends Controller{
    public function index(){

        if(Input::exists()){
            if(Token::check(Input::get('token'))){

                $v = new Validar();
                $validacao = $v->check($_POST, array(
                    'usuario' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20,
                        'unique' => 'usuario'
                    ),
                    'senha' => array(
                        'required' => true,
                        'min' => 6
                    ),
                    'senha2' => array(
                        'required' => true,
                        'matches' => 'senha'
                    ),
                    'nome' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    )
                ));

                if($validacao->aprovada()){
                    Session::flash('sucesso', 'Você foi registrado com sucesso');
                    header('Location: home');
                }
                else{
                    foreach($validacao->erros() as $erro){
                        echo $erro.'<br>';
                    }
                }
            }

        }

        $this->view();
    }
}
