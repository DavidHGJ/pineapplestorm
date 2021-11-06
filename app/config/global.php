<?php

error_reporting(E_ERROR | E_PARSE);

define('METHOD', $_SERVER['REQUEST_METHOD']);

define('PATH_APP', __DIR__ . '\\..\\..\\app\\');
define('PATH_ROOT', __DIR__ . '\\..\\..\\');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');
header('Access-Control-Max-Age: 1728000');
header('Content-Length: 0');
header('Content-Type: text/plain');

require_once PATH_APP . 'helpers/Filtro.php';

// $urlRecuperada = explode('/', $_SERVER['REQUEST_URI']);
// define('URL', '/' . $urlRecuperada[1] . '/');
// define('URL_ASSETS', '/' . $urlRecuperada[1] . '/public/assets/');
// define('URL_CSS', '/' . $urlRecuperada[1] . '/public/css/');
// define('URL_JS', '/' . $urlRecuperada[1] . '/public/js/');