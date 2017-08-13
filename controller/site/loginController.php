<?php

/**
 * @author Gabriel Schmidt Cordeiro <gabrielscordeiro2012@gmail.com>
 */

namespace controller\site;

use lib\Controller;

class loginController extends Controller {

    public function index() {
        $this->view('login');
    }

}
