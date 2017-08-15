<?php
namespace controller\admin;
use lib\Controller;
use lib\Usuario;
use lib\Redirecionar;

class logoutController extends Controller{
    public function index(){
        $usuario = new Usuario();
        $usuario->logout();

        Redirecionar::para('login');
    }
}
