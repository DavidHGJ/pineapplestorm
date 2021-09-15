<?php

use models\class\queryManager\QueryManager;
use models\class\util\Rota;
use models\class\queryManager\TableManager;

require 'app/models/autoload.php';
require 'vendor/autoload.php';

if ($_REQUEST['url'] != null)
    $urlAtual = explode('/', $_REQUEST['url']);
else $urlAtual[] = 'login';

$rota = new Rota($urlAtual);

require_once $rota->caminhoPagina;