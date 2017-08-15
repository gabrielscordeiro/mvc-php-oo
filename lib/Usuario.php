<?php
namespace lib;

use \Exception;
use lib\Config;
use lib\Database;
use lib\Hash;
use lib\Session;
use lib\Redirecionar;
use lib\Cookie;

class Usuario{
    private $_db;
    private $_dado;
    private $_sessionName;
    private $_cookieName;
    private $_isLogado;

    public function __construct($usuario = null){
        $this->_db = Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$usuario){
            if(Session::exists($this->_sessionName)){
                $usuario = Session::get($this->_sessionName);

                if($this->find($usuario)){
                    $this->_isLogado = true;
                }
                else {
                    $this->logout();
                }
            }
        }
        else {
            $this->find($usuario);
        }

        /*if(!$this->isLogado()){
            Session::put('login', 'Você precisa efetuar o log in!');
            Redirecionar::para('login');
        }*/
    }

    public function criar($campos = array()){
        if(!$this->_db->insert('usuario', $campos)){
            throw new Exception('Houve um problema ao criar uma nova conta');
        }
    }

    public function find($usuario = null){
        if($usuario){
            $campo = (is_numeric($usuario)) ? 'codigo' : 'usuario';
            $dados = $this->_db->get('usuario', array($campo, '=', $usuario));

            if($dados->count()){
                $this->_dado = $dados->first();
                return true;
            }
        }
        return false;
    }

    public function login($usuario = null, $senha = null, $remember = false){
        $user = $this->find($usuario);
        if($user){
            if($this->dado()->senha === Hash::make($senha, $this->dado()->salt)){
                Session::put($this->_sessionName, $this->dado()->codigo);

                if($remember){
                    $hash = Hash::unique();
                    $hashCheck = $this->_db->get('usuario_sessao', array('codigo_usuario', '=', $this->dado()->codigo));

                    if(!$hashCheck->count()){
                        $this->_db->insert('usuario_sessao', array(
                            'codigo_usuario' => $this->dado()->codigo,
                            'hash' => $hash
                        ));
                    }
                    else {
                        $hash = $hashCheck->first()->hash;
                    }

                    Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    
                }

                return true;
            }
        }

        return false;
    }

    public function logout(){
        Session::delete($this->_sessionName);
    }

    public function dado(){
        return $this->_dado;
    }

    public function isLogado(){
        return $this->_isLogado;
    }
}
?>
