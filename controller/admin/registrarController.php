<?php

namespace controller\admin;

use lib\Controller;
use lib\Input;
use lib\Validar;
use lib\Token;
use lib\Session;
use lib\Hash;
use lib\Usuario;
use lib\Redirecionar;

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
                    $usuario = new Usuario();
                    $salt = Hash::salt(32);

                    try{
                        $usuario->criar(array(
                            'usuario'       => Input::get('usuario'),
                            'senha'         => Hash::make(Input::get('senha'), $salt),
                            'salt'          => $salt,
                            'nome'          => Input::get('nome'),
                            'data_registro' => date('d/m/Y'),
                            'grupo'         => 1
                        ));

                        Session::flash('home', 'Você foi registrado com sucesso! Agora você pode fazer seu log in');
                        Redirecionar::para('home');
                    }
                    catch(Exception $e){
                        //talvez redirecionar pra outra pagina pra avisar que deu o erro
                        Session::flash('home', 'Ocorreu um erro ao efetuar o cadastro. Detalhes: '.$e->getMessage());
                        Redirecionar::para('home');
                    }
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
