<?php

error_reporting(E_ERROR | E_PARSE);

define('METHOD', $_SERVER['REQUEST_METHOD']);

define('PATH_APP', __DIR__ . '\\..\\..\\app\\');
define('PATH_ROOT', __DIR__ . '\\..\\..\\');

require_once PATH_APP . 'helpers/Filtro.php';

// $urlRecuperada = explode('/', $_SERVER['REQUEST_URI']);
// define('URL', '/' . $urlRecuperada[1] . '/');
// define('URL_ASSETS', '/' . $urlRecuperada[1] . '/public/assets/');
// define('URL_CSS', '/' . $urlRecuperada[1] . '/public/css/');
// define('URL_JS', '/' . $urlRecuperada[1] . '/public/js/');