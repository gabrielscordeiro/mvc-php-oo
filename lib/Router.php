<?php

namespace lib;

/**
 * Description of Router
 *
 * @author Gabriel
 */
class Router {

    protected $routers = Array(
        'site' => 'site',
        'admin' => 'admin'
    );
    protected $routerOnRaiz = 'site';
    protected $onRaiz = true;

}
