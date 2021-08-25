<?php

error_reporting(E_ERROR | E_PARSE);

define('PAGINA_INICIAL', 'login');
define('PAGINA_ERRO', 'erro');

define('PATH_PUBLIC', __DIR__ . '\\..\\..\\public\\');
define('PATH_APP', __DIR__ . '\\..\\..\\app\\');
define('PATH_PAGE', __DIR__ . '\\..\\..\\public\\pages\\');
define('PATH_ASSETS', __DIR__ . '\\..\\..\\public\\assets\\');
define('PATH_INCLUDES', __DIR__ . '\\..\\..\\public\\includes\\');

$urlRecuperada = explode('/', $_SERVER['REQUEST_URI']);
define('URL', '/' . $urlRecuperada[1] . '/');
define('URL_ASSETS', '/' . $urlRecuperada[1] . '/public/assets/');
define('URL_CSS', '/' . $urlRecuperada[1] . '/public/css/');
define('URL_JS', '/' . $urlRecuperada[1] . '/public/js/');


define('TITLE', ucfirst(end($urlRecuperada)));

require_once PATH_APP . 'helpers/inclusao.php';
require_once PATH_APP . 'helpers/filtro.php';