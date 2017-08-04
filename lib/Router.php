<?php

namespace lib;

/**
 * Description of Router
 *
 * @author Gabriel Schmidt Cordeiro <gabrielscordeiro2012@gmail.com.br>
 */
class Router {

    protected $routers = Array(
        'site' => 'site',
        'admin' => 'admin'
    );
    
    private $urlBase = APP_ROOT;
    protected $routerOnRaiz = 'site';
    protected $onRaiz = true;

}
