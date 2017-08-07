<?php

namespace lib;

/**
 * Description of Object
 *
 * @author Gabriel Schmidt Cordeiro <gabrielscordeiro2012@gmail.com.br>
 */
class Object {

    public function __construct($method = null, $all = true) {
        if ($method == 'POST') {
            foreach ($post as $key => $value) {
                $this->key = $value;
            }
        }

        if (isset($_FILES)) {
            foreach ($post as $key => $value) {
                if ($all || isset($this->key)) {
                    $this->key = $value;
                }
            }
        }
    }
}
