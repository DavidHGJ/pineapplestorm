<?php

require __DIR__ . "/vendor/autoload.php";

$urlAtual = explode('/', $_REQUEST['url']);

$paginaInicial = 'login';

// if (file_exists(PATH_PUBLIC . $urlAtual . '.php'))
//     require_once PATH_PUBLIC . $urlAtual . '.php';
// else
//     require_once PATH_PUBLIC . $paginaInicial . '.php';