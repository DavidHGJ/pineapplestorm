<?php

define('PAGINA_INICIAL', 'erro');

define('PATH_PUBLIC', __DIR__ . '\\..\\..\\public\\');
define('PATH_APP', __DIR__ . '\\..\\..\\app\\');
define('PATH_PAGE', __DIR__ . '\\..\\..\\public\\pages\\');
define('PATH_ASSETS', __DIR__ . '\\..\\..\\public\\assets\\');
define('PATH_INCLUDES', __DIR__ . '\\..\\..\\public\\includes\\');

$urlRecuperada = explode('/', $_SERVER['REQUEST_URI']);
define('URL', '/' . $urlRecuperada[1] . '/');
define('URL_ASSETS', '/' . $urlRecuperada[1] . '/public/assets/');

define('TITLE', ucfirst(end($urlRecuperada)));