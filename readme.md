Projeto de um mini framework desenvolvido em PHP, Vue.js e Sass usando a estrutura MVC

Em core/init.php está instanciado as configurações em modo de um array Global e também contém o
autoload_register que faz dar o require das classes automaticamente.

Estão implementadas as funcionalidades do select, insert, update e delete em Database.php

Alterações 13/08/2017:
core/init.php fazia a mesma função do helper/Bootstrap.php, fundi os dois arquivos em um só e excluí o core/init;
Adicionados alguns comentários que servem de dicas e/ou sugestões no index.php
