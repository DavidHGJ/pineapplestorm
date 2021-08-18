<?php

use app\models\class\teste;

require __DIR__ . "/vendor/autoload.php";

$url_atual = $_REQUEST['url'];

if (file_exists(PATH_PUBLIC . $url_atual . '.php'))
    require_once PATH_PUBLIC . $url_atual . '.php';
else echo 'Página não existe';